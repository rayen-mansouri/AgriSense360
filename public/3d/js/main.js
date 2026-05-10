import * as THREE from 'three';
import { OrbitControls } from 'three/addons/controls/OrbitControls.js';
import { EffectComposer } from 'three/addons/postprocessing/EffectComposer.js';
import { RenderPass } from 'three/addons/postprocessing/RenderPass.js';
import { UnrealBloomPass } from 'three/addons/postprocessing/UnrealBloomPass.js';
import gsap from 'gsap';

import { PlantFactory } from './PlantFactory.js';
import { TerrainSystem } from './terrain.js';
import { WeatherSystem } from './weather.js';
import { SkySystem } from './sky.js';
import { UISystem } from './ui.js';

class AgriSense3D {
    constructor() {
        this.scene = new THREE.Scene();
        this.camera = new THREE.PerspectiveCamera(60, window.innerWidth / window.innerHeight, 0.1, 2000);
        
        this.renderer = new THREE.WebGLRenderer({ antialias: true, logarithmicDepthBuffer: true });
        this.renderer.setSize(window.innerWidth, window.innerHeight);
        this.renderer.setPixelRatio(Math.min(window.devicePixelRatio, 2));
        this.renderer.shadowMap.enabled = true;
        this.renderer.shadowMap.type = THREE.PCFSoftShadowMap;
        this.renderer.toneMapping = THREE.ACESFilmicToneMapping;
        this.renderer.toneMappingExposure = 1.0;
        document.body.appendChild(this.renderer.domElement);

        this.composer = new EffectComposer(this.renderer);
        this.composer.addPass(new RenderPass(this.scene, this.camera));
        this.composer.addPass(new UnrealBloomPass(
            new THREE.Vector2(window.innerWidth, window.innerHeight),
            0.6, 0.4, 0.85
        ));

        this.controls = new OrbitControls(this.camera, this.renderer.domElement);
        this.controls.enableDamping = true;
        this.controls.dampingFactor = 0.05;
        this.controls.maxPolarAngle = Math.PI / 2.1;
        
        this.plantFactory = new PlantFactory();
        this.terrain = new TerrainSystem(this.scene);
        this.weather = new WeatherSystem(this.scene);
        this.sky = new SkySystem(this.scene);
        this.ui = new UISystem();
        
        this.clock = new THREE.Clock();
        this.mouse = new THREE.Vector2();
        this.raycaster = new THREE.Raycaster();
        
        this.isWalkMode = false;
        this.walkKeys = {};
        this.walkVelocity = new THREE.Vector3();
        
        this.init();
    }

    init() {
        window.addEventListener('resize', () => this.onResize());
        window.addEventListener('mousemove', (e) => this.onMouseMove(e));
        window.addEventListener('mousedown', () => this.onMouseDown());
        window.addEventListener('keydown', (e) => this.onKeyDown(e));
        window.addEventListener('keyup', (e) => this.onKeyUp(e));

        document.getElementById('btnDrone').onclick = () => this.toggleMode(false);
        document.getElementById('btnWalk').onclick = () => this.toggleMode(true);

        // Receive data from Twig wrapper
        window.setParcelleData = (json) => {
            const data = JSON.parse(json);
            this.buildWorld(data);
            this.ui.updatePanel(data);
        };

        // Initial Cinematic
        this.camera.position.set(0, 500, 300);
        this.controls.target.set(0, 0, 0);

        setTimeout(() => {
            document.getElementById('loader').style.opacity = '0';
            setTimeout(() => document.getElementById('loader').remove(), 1500);
        }, 2000);

        this.animate();
    }

    buildWorld(data) {
        // Since we are in detail page, usually one parcelle, but let's center it
        const pSize = 150;
        this.terrain.createParcelleGround(data, 0, 0, pSize, pSize);
        
        // Add localized weather based on data or random if missing
        const weatherType = data.weather || ['pluie', 'orage', 'soleil', 'nuageux'][Math.floor(Math.random()*4)];
        this.weather.addLocalWeather(weatherType, 0, 0, pSize, pSize);
        
        // Populate Plants
        const cultures = data.cultures || [];
        cultures.forEach((c, idx) => {
            const plantData = this.plantFactory.getPlantData(c.nom || c.typeCulture, c.growth || 50);
            this.instantiatePlants(plantData, idx, cultures.length, pSize);
        });
    }

    instantiatePlants(parts, index, total, pSize) {
        // Divide parcelle into strips for multiple cultures
        const stripW = pSize / total;
        const startX = -pSize/2 + (index * stripW);
        const centerX = startX + stripW/2;

        parts.forEach(part => {
            const count = 300; // AAA density
            const mesh = new THREE.InstancedMesh(part.geo, part.mat, count);
            mesh.castShadow = true;
            mesh.receiveShadow = true;
            this.scene.add(mesh);

            const dummy = new THREE.Object3D();
            for(let i=0; i<count; i++) {
                const px = centerX + (Math.random()-0.5) * stripW * 0.9;
                const pz = (Math.random()-0.5) * pSize * 0.9;
                dummy.position.set(px, 0, pz);
                dummy.rotation.y = Math.random() * Math.PI;
                dummy.updateMatrix();
                mesh.setMatrixAt(i, dummy.matrix);
            }
        });
    }

    toggleMode(walk) {
        this.isWalkMode = walk;
        document.getElementById('btnDrone').classList.toggle('active', !walk);
        document.getElementById('btnWalk').classList.toggle('active', walk);
        
        if (walk) {
            this.renderer.domElement.requestPointerLock();
            this.controls.enabled = false;
        } else {
            document.exitPointerLock();
            this.controls.enabled = true;
        }
    }

    onMouseMove(e) {
        this.mouse.x = (e.clientX / window.innerWidth) * 2 - 1;
        this.mouse.y = -(e.clientY / window.innerHeight) * 2 + 1;

        if (this.isWalkMode && document.pointerLockElement) {
            this.camera.rotation.order = 'YXZ';
            this.camera.rotation.y -= e.movementX * 0.002;
            this.camera.rotation.x -= e.movementY * 0.002;
            this.camera.rotation.x = Math.max(-Math.PI/2, Math.min(Math.PI/2, this.camera.rotation.x));
        }
    }

    onMouseDown() {
        if (this.isWalkMode) return;
        this.raycaster.setFromCamera(this.mouse, this.camera);
        // Intersect logic for UI update if needed
    }

    onKeyDown(e) { 
        this.walkKeys[e.code] = true;
        if (e.code === 'Space') this.toggleMode(!this.isWalkMode);
    }
    onKeyUp(e) { this.walkKeys[e.code] = false; }

    onResize() {
        this.camera.aspect = window.innerWidth / window.innerHeight;
        this.camera.updateProjectionMatrix();
        this.renderer.setSize(window.innerWidth, window.innerHeight);
        this.composer.setSize(window.innerWidth, window.innerHeight);
    }

    animate() {
        requestAnimationFrame(() => this.animate());
        const delta = this.clock.getDelta();
        const time = this.clock.getElapsedTime();

        this.sky.animate(time);
        this.weather.animate(delta, time);

        if (this.isWalkMode) {
            this.updateWalk(delta);
        } else {
            this.controls.update();
        }

        this.composer.render();
    }

    updateWalk(delta) {
        const speed = 10 * delta;
        const dir = new THREE.Vector3();
        if (this.walkKeys['KeyW']) dir.z -= 1;
        if (this.walkKeys['KeyS']) dir.z += 1;
        if (this.walkKeys['KeyA']) dir.x -= 1;
        if (this.walkKeys['KeyD']) dir.x += 1;
        
        dir.applyQuaternion(this.camera.quaternion);
        dir.y = 0;
        dir.normalize();
        
        this.camera.position.add(dir.multiplyScalar(speed));
        // Simple ground constraint
        this.camera.position.y = 2;
    }
}

new AgriSense3D();
