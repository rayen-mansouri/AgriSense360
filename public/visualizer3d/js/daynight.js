import * as THREE from 'three';
import { Sky } from 'three/addons/objects/Sky.js';

export class DayNightSystem {
    constructor(scene) {
        this.scene = scene;
        this.init();
    }

    init() {
        this.sky = new Sky();
        this.sky.scale.setScalar(450000);
        this.scene.add(this.sky);

        this.sun = new THREE.Vector3();
        
        this.dirLight = new THREE.DirectionalLight(0xfff5e0, 2.0);
        this.dirLight.castShadow = true;
        this.dirLight.shadow.mapSize.width = 4096;
        this.dirLight.shadow.mapSize.height = 4096;
        this.dirLight.shadow.camera.left = -200;
        this.dirLight.shadow.camera.right = 200;
        this.dirLight.shadow.camera.top = 200;
        this.dirLight.shadow.camera.bottom = -200;
        this.dirLight.shadow.camera.far = 1000;
        this.scene.add(this.dirLight);

        this.hemiLight = new THREE.HemisphereLight(0x87ceeb, 0x4a3728, 0.6);
        this.scene.add(this.hemiLight);

        this.params = {
            turbidity: 2,
            rayleigh: 3,
            mieCoefficient: 0.005,
            mieDirectionalG: 0.8,
            elevation: 2,
            azimuth: 180,
            time: 0
        };

        this.updateSky();
    }

    updateSky() {
        const uniforms = this.sky.material.uniforms;
        uniforms['turbidity'].value = this.params.turbidity;
        uniforms['rayleigh'].value = this.params.rayleigh;
        uniforms['mieCoefficient'].value = this.params.mieCoefficient;
        uniforms['mieDirectionalG'].value = this.params.mieDirectionalG;

        const phi = THREE.MathUtils.degToRad(90 - this.params.elevation);
        const theta = THREE.MathUtils.degToRad(this.params.azimuth);

        this.sun.setFromSphericalCoords(1, phi, theta);
        uniforms['sunPosition'].value.copy(this.sun);
        this.dirLight.position.copy(this.sun).multiplyScalar(400);

        // Update colors based on sun position
        const sunHeight = Math.max(0, this.sun.y);
        this.dirLight.intensity = sunHeight * 2.5;
        this.hemiLight.intensity = 0.2 + sunHeight * 0.8;
        
        // Colors
        if (sunHeight < 0.1) {
            this.dirLight.color.setHex(0xff7043); // Orange sunrise/set
        } else {
            this.dirLight.color.setHex(0xfff5e0); // Noon
        }
    }

    animate(delta) {
        this.params.time += delta * 0.05; // 60s cycle roughly
        
        // Loop elevation from 2 to 90 and back
        this.params.elevation = 2 + Math.sin(this.params.time) * 88;
        
        this.updateSky();

        // Get readable time
        const hour = (Math.sin(this.params.time) + 1) * 12;
        let timeLabel = "Jour";
        if (hour < 6 || hour > 18) timeLabel = "Crépuscule";
        else if (hour > 10 && hour < 14) timeLabel = "Zénith";
        else if (hour < 10) timeLabel = "Matin";
        else timeLabel = "Après-midi";

        return timeLabel;
    }
}
