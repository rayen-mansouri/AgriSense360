import * as THREE from 'three';

export class SkySystem {
    constructor(scene) {
        this.scene = scene;
        this.init();
    }

    init() {
        // Skybox
        const skyGeo = new THREE.SphereGeometry(1000, 32, 32);
        const skyMat = new THREE.MeshBasicMaterial({
            color: 0x020617,
            side: THREE.BackSide
        });
        this.skybox = new THREE.Mesh(skyGeo, skyMat);
        this.scene.add(this.skybox);

        // Stars
        this.initStars();
        
        // Moon
        this.initMoon();
        
        // Aurora (Optional visual polish)
        this.initAurora();
    }

    initStars() {
        const starGeo = new THREE.BufferGeometry();
        const starPos = [];
        const starOpacities = [];
        for (let i = 0; i < 3000; i++) {
            const x = THREE.MathUtils.randFloatSpread(2000);
            const y = THREE.MathUtils.randFloat(100, 1000);
            const z = THREE.MathUtils.randFloatSpread(2000);
            starPos.push(x, y, z);
            starOpacities.push(Math.random());
        }
        starGeo.setAttribute('position', new THREE.Float32BufferAttribute(starPos, 3));
        starGeo.setAttribute('opacity', new THREE.Float32BufferAttribute(starOpacities, 1));

        const starMat = new THREE.PointsMaterial({
            color: 0xffffff,
            size: 0.8,
            transparent: true,
            opacity: 1,
            sizeAttenuation: true
        });
        this.stars = new THREE.Points(starGeo, starMat);
        this.scene.add(this.stars);
    }

    initMoon() {
        const moonGeo = new THREE.SphereGeometry(20, 32, 32);
        const moonMat = new THREE.MeshStandardMaterial({
            color: 0xfffde0,
            emissive: 0x888860,
            emissiveIntensity: 0.5
        });
        this.moon = new THREE.Mesh(moonGeo, moonMat);
        this.moon.position.set(200, 400, -300);
        this.scene.add(this.moon);

        // Moon light
        this.moonLight = new THREE.DirectionalLight(0xc8d8ff, 0.4);
        this.moonLight.position.copy(this.moon.position);
        this.moonLight.castShadow = true;
        this.moonLight.shadow.mapSize.width = 2048;
        this.moonLight.shadow.mapSize.height = 2048;
        this.moonLight.shadow.camera.left = -500;
        this.moonLight.shadow.camera.right = 500;
        this.moonLight.shadow.camera.top = 500;
        this.moonLight.shadow.camera.bottom = -500;
        this.scene.add(this.moonLight);

        // Ambient blue-ish night light
        const ambient = new THREE.AmbientLight(0x1a1a2e, 0.4);
        this.scene.add(ambient);
    }

    initAurora() {
        const auroraGroup = new THREE.Group();
        const colors = [0x22c55e, 0xa855f7];
        for(let i=0; i<3; i++) {
            const geo = new THREE.PlaneGeometry(1000, 200, 10, 1);
            const mat = new THREE.MeshBasicMaterial({
                color: colors[i%2],
                transparent: true,
                opacity: 0.05,
                side: THREE.DoubleSide,
                depthWrite: false
            });
            const aurora = new THREE.Mesh(geo, mat);
            aurora.position.set(0, 300, -400 - i*50);
            aurora.rotation.x = Math.PI / 2;
            auroraGroup.add(aurora);
        }
        this.aurora = auroraGroup;
        this.scene.add(this.aurora);
    }

    animate(time) {
        // Twinkle stars
        const opacities = this.stars.geometry.attributes.opacity.array;
        for (let i = 0; i < opacities.length; i++) {
            opacities[i] = 0.5 + Math.sin(time * 2 + i) * 0.5;
        }
        this.stars.geometry.attributes.opacity.needsUpdate = true;

        // Move aurora waves
        this.aurora.children.forEach((a, i) => {
            a.position.x = Math.sin(time * 0.2 + i) * 100;
            a.scale.y = 1 + Math.sin(time * 0.5 + i) * 0.2;
        });
    }
}
