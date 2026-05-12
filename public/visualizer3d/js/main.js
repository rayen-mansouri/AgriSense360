import * as THREE from 'three';
import { EffectComposer } from 'three/addons/postprocessing/EffectComposer.js';
import { RenderPass } from 'three/addons/postprocessing/RenderPass.js';

import { PlantFactory } from './PlantFactory.js';
import { TerrainSystem } from './terrain.js';
import { SkySystem } from './sky.js';
import { UISystem } from './ui.js';

import gsap from 'gsap';

class AgriSense3D {
    constructor() {
        this.scene = new THREE.Scene();
        this.camera = new THREE.PerspectiveCamera(75, window.innerWidth / window.innerHeight, 0.1, 1000);
        
        this.renderer = new THREE.WebGLRenderer({ antialias: false });
        this.renderer.setSize(window.innerWidth, window.innerHeight);
        this.renderer.setPixelRatio(1);
        this.renderer.shadowMap.enabled = true;
        document.body.appendChild(this.renderer.domElement);

        this.composer = new EffectComposer(this.renderer);
        this.composer.addPass(new RenderPass(this.scene, this.camera));
        
        this.plantFactory = new PlantFactory();
        this.terrain = new TerrainSystem(this.scene);
        this.sky = new SkySystem(this.scene);
        this.ui = new UISystem();
        
        this.plants = []; // Store plant groups for wind
        
        this.clock = new THREE.Clock();
        this.walkKeys = {};
        this.currentZoneId = null;
        
        this.init();
    }

    init() {
        window.addEventListener('resize', () => this.onResize());
        window.addEventListener('keydown', (e) => this.onKeyDown(e));
        window.addEventListener('keyup', (e) => this.onKeyUp(e));
        window.addEventListener('mousedown', () => {
            if (!document.pointerLockElement) this.renderer.domElement.requestPointerLock();
        });
        window.addEventListener('mousemove', (e) => this.onMouseMove(e));

        window.setParcelleData = (json) => {
            const data = JSON.parse(json);
            this.buildWorld(data);
            this.ui.updatePanel(data);
        };

        this.camera.position.set(0, 2, 60);
        
        setTimeout(() => {
            const loader = document.getElementById('loader');
            if (loader) {
                loader.style.opacity = '0';
                setTimeout(() => loader.remove(), 1000);
            }
            // Signal parent that we are ready
            if (window.parent && window.parent !== window) {
                window.parent.postMessage({ type: '3D_READY' }, '*');
            }
        }, 1000);

        this.animate();
    }

    buildWorld(data) {
        const pSize = 100;
        this.terrain.createParcelleGround(data, 0, 0, pSize, pSize);
        
        // Clear old plants
        this.plants.forEach(p => this.scene.remove(p));
        this.plants = [];

        this.terrain.zones.forEach(zone => {
            this.instantiateZonePlants(zone, pSize);
        });
    }

    instantiateZonePlants(zone, pSize) {
        const zoneW = zone.bounds.maxX - zone.bounds.minX;
        const zoneD = zone.bounds.maxZ - zone.bounds.minZ;
        const centerX = zone.bounds.minX + zoneW / 2;
        const centerZ = zone.bounds.minZ + zoneD / 2;

        const count = Math.min(150, Math.floor((zone.surface / 100) * 80)); // Limit for performance
        
        for(let i=0; i<count; i++) {
            const plant = this.plantFactory.getPlantData(zone.nom || zone.type, zone.growth || 80, i);
            const px = centerX + (Math.random()-0.5) * zoneW * 0.8;
            const pz = centerZ + (Math.random()-0.5) * zoneD * 0.8;
            
            plant.position.set(px, 0, pz);
            plant.rotation.y = Math.random() * Math.PI * 2;
            
            this.scene.add(plant);
            this.plants.push(plant);
        }
    }

    onMouseMove(e) {
        if (document.pointerLockElement) {
            this.camera.rotation.order = 'YXZ';
            this.camera.rotation.y -= e.movementX * 0.003;
            this.camera.rotation.x -= e.movementY * 0.003;
            this.camera.rotation.x = Math.max(-Math.PI/2, Math.min(Math.PI/2, this.camera.rotation.x));
        }
    }

    onKeyDown(e) { this.walkKeys[e.code] = true; }
    onKeyUp(e) { this.walkKeys[e.code] = false; }

    onResize() {
        this.camera.aspect = window.innerWidth / window.innerHeight;
        this.camera.updateProjectionMatrix();
        this.renderer.setSize(window.innerWidth, window.innerHeight);
    }

    animate() {
        requestAnimationFrame(() => this.animate());
        const delta = this.clock.getDelta();
        const time = this.clock.getElapsedTime();
        
        this.updateWalk(delta);
        this.updateWind(time);
        this.checkPlayerZone();
        this.composer.render();
    }

    updateWind(time) {
        const windSpeed = 1.2;
        this.plants.forEach(p => {
            const seed = p.userData.windSeed;
            const strength = p.userData.windStrength;
            p.rotation.z = Math.sin(time * windSpeed + seed) * strength * 0.05;
            
            // Stalk specific sway
            if (p.children[0]) {
                p.children[0].rotation.z = Math.sin(time * windSpeed + seed) * strength * 0.02;
            }
        });
    }

    updateWalk(delta) {
        const speed = 15 * delta;
        const dir = new THREE.Vector3();
        if (this.walkKeys['KeyW']) dir.z -= 1;
        if (this.walkKeys['KeyS']) dir.z += 1;
        if (this.walkKeys['KeyA']) dir.x -= 1;
        if (this.walkKeys['KeyD']) dir.x += 1;
        
        dir.applyQuaternion(this.camera.quaternion);
        dir.y = 0;
        dir.normalize();
        
        this.camera.position.add(dir.multiplyScalar(speed));
        this.camera.position.y = 2.0; 
    }

    checkPlayerZone() {
        const zone = this.terrain.checkPlayerZone(this.camera.position.x, this.camera.position.z);
        if (zone) {
            if (this.currentZoneId !== zone.id) {
                this.currentZoneId = zone.id;
                this.ui.showLocalReport(zone);
            }
        } else {
            if (this.currentZoneId !== null) {
                this.currentZoneId = null;
                this.ui.hideLocalReport();
            }
        }
    }
}

new AgriSense3D();
