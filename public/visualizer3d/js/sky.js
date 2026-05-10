import * as THREE from 'three';

export class SkySystem {
    constructor(scene) {
        this.scene = scene;
        this.init();
    }

    init() {
        // Bright Minecraft Blue
        this.scene.background = new THREE.Color(0x78a7ff);
        
        // Very strong direct sun
        this.sunLight = new THREE.DirectionalLight(0xffffff, 2.0);
        this.sunLight.position.set(50, 100, 50);
        this.sunLight.castShadow = true;
        this.sunLight.shadow.mapSize.width = 2048;
        this.sunLight.shadow.mapSize.height = 2048;
        this.scene.add(this.sunLight);

        // Sky light
        this.hemiLight = new THREE.HemisphereLight(0xffffff, 0x000000, 0.5);
        this.scene.add(this.hemiLight);
    }

    animate(time) {
        // No animation needed for blocky style
    }
}
