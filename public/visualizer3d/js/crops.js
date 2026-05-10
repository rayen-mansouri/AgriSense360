import * as THREE from 'three';

export class CropSystem {
    constructor(scene) {
        this.scene = scene;
        this.plants = [];
        this.zones = new THREE.Group();
        this.scene.add(this.zones);
    }

    createParcelle(data, centerX, centerZ, width, depth) {
        const config = this.getCropConfig(data.typeCulture);
        
        // Zone Border (Glowing)
        const zoneGeo = new THREE.BoxGeometry(width, 0.5, depth);
        const edges = new THREE.EdgesGeometry(zoneGeo);
        const lineMat = new THREE.LineBasicMaterial({ color: config.color });
        const line = new THREE.LineSegments(edges, lineMat);
        line.position.set(centerX, 0.5, centerZ);
        line.userData = { isZone: true, data: data };
        this.zones.add(line);

        // Invisible box for clicking
        const hitBox = new THREE.Mesh(zoneGeo, new THREE.MeshBasicMaterial({ transparent: true, opacity: 0 }));
        hitBox.position.copy(line.position);
        hitBox.userData = { isZone: true, data: data };
        this.zones.add(hitBox);

        // Instanced Plants
        const growth = data.growth / 100;
        const countX = Math.floor(width * config.density * growth);
        const countZ = Math.floor(depth * config.density * growth);
        const count = countX * countZ;

        if (count > 0) {
            this.generatePlantInstances(config, count, countX, countZ, centerX, centerZ, width, depth, growth);
        }
    }

    generatePlantInstances(config, count, countX, countZ, centerX, centerZ, width, depth, growth) {
        const geometries = this.getGeometries(config.type);
        const materials = this.getMaterials(config.type, config.color);

        const meshes = geometries.map((geo, i) => {
            const mesh = new THREE.InstancedMesh(geo, materials[i] || materials[0], count);
            mesh.castShadow = true;
            mesh.receiveShadow = true;
            this.scene.add(mesh);
            return mesh;
        });

        const dummy = new THREE.Object3D();
        let idx = 0;
        const spacingX = width / countX;
        const spacingZ = depth / countZ;

        for (let x = 0; x < countX; x++) {
            for (let z = 0; z < countZ; z++) {
                const px = centerX - (width / 2) + (x * spacingX) + (Math.random() * 0.5);
                const pz = centerZ - (depth / 2) + (z * spacingZ) + (Math.random() * 0.5);
                
                dummy.position.set(px, 0, pz);
                dummy.rotation.y = Math.random() * Math.PI;
                const s = config.scale * (0.8 + Math.random() * 0.4) * growth;
                dummy.scale.set(s, s, s);
                dummy.updateMatrix();
                
                meshes.forEach(m => m.setMatrixAt(idx, dummy.matrix));
                idx++;
            }
        }

        this.plants.push({ meshes, config, count, startTime: Math.random() * 10 });
    }

    getGeometries(type) {
        switch (type) {
            case 'wheat': {
                const stalk = new THREE.CylinderGeometry(0.02, 0.04, 2, 4);
                stalk.translate(0, 1, 0);
                const head = new THREE.SphereGeometry(0.08, 4, 4);
                head.translate(0, 2, 0);
                return [stalk, head];
            }
            case 'corn': {
                const stalk = new THREE.CylinderGeometry(0.1, 0.1, 3, 5);
                stalk.translate(0, 1.5, 0);
                const cob = new THREE.CylinderGeometry(0.2, 0.2, 0.8, 6);
                cob.translate(0, 2.5, 0);
                return [stalk, cob];
            }
            case 'tomato': {
                const bush = new THREE.IcosahedronGeometry(1.2, 1);
                bush.translate(0, 1, 0);
                const fruit = new THREE.SphereGeometry(0.2, 6, 6);
                fruit.translate(0, 1.5, 0.8); // Offset some
                return [bush, fruit];
            }
            case 'sunflower': {
                const stalk = new THREE.CylinderGeometry(0.1, 0.1, 4, 5);
                stalk.translate(0, 2, 0);
                const head = new THREE.CircleGeometry(0.8, 12);
                head.rotateX(-Math.PI/2);
                head.translate(0, 4.2, 0);
                return [stalk, head];
            }
            default:
                return [new THREE.BoxGeometry(0.5, 1, 0.5)];
        }
    }

    getMaterials(type, color) {
        const standard = new THREE.MeshStandardMaterial({ color: color, roughness: 0.8 });
        switch (type) {
            case 'wheat': return [standard, new THREE.MeshStandardMaterial({ color: 0xd97706 })];
            case 'corn': return [new THREE.MeshStandardMaterial({ color: 0x166534 }), new THREE.MeshStandardMaterial({ color: 0xfacc15 })];
            case 'tomato': return [new THREE.MeshStandardMaterial({ color: 0x14532d }), new THREE.MeshStandardMaterial({ color: 0xef4444 })];
            case 'sunflower': return [new THREE.MeshStandardMaterial({ color: 0x166534 }), new THREE.MeshStandardMaterial({ color: 0xfacc15 })];
            default: return [standard];
        }
    }

    getCropConfig(type) {
        const configs = {
            'Blé': { type: 'wheat', color: 0xf59e0b, density: 1.2, scale: 1.0 },
            'Maïs': { type: 'corn', color: 0x22c55e, density: 0.6, scale: 1.2 },
            'Tomate': { type: 'tomato', color: 0xef4444, density: 0.4, scale: 0.8 },
            'Tournesol': { type: 'sunflower', color: 0xeab308, density: 0.5, scale: 1.0 },
            'default': { type: 'generic', color: 0x10b981, density: 1.0, scale: 1.0 }
        };
        return configs[type] || configs['default'];
    }

    animate(time) {
        this.plants.forEach(p => {
            if (p.config.type === 'wheat') {
                const tilt = Math.sin(time + p.startTime) * 0.1;
                // Note: Updating instance matrices every frame is heavy. 
                // In AAA this would be a vertex shader. 
                // For simplicity here, we only tilt the whole meshes if needed or just skip for perf.
                p.meshes.forEach(m => {
                    m.rotation.x = tilt;
                });
            }
        });
    }
}
