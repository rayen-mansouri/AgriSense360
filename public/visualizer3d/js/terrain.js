import * as THREE from 'three';

export class TerrainSystem {
    constructor(scene) {
        this.scene = scene;
        this.parcelleGrounds = new THREE.Group();
        this.scene.add(this.parcelleGrounds);
        this.zones = []; // Store zone boundaries for player detection
    }

    createParcelleGround(data, centerX, centerZ, width, depth) {
        // Soil Color Logic
        const soilColors = {
            'sableux': 0xe3c58e, // Sandy Yellow
            'argileux': 0x8b5a2b, // Clay Brown
            'limoneux': 0x4a3728, // Loam Dark Brown
            'calcaire': 0xd1d5db, // Limestone Grey
            'default': 0x4aa02c  // Grass Green
        };
        const soilType = (data.typeSol || '').toLowerCase();
        const color = soilColors[soilType] || soilColors['default'];

        // Main Ground Block
        const geo = new THREE.BoxGeometry(width, 1, depth);
        const mat = new THREE.MeshStandardMaterial({ color: color, roughness: 1 });
        const ground = new THREE.Mesh(geo, mat);
        ground.position.set(centerX, -0.5, centerZ);
        ground.receiveShadow = true;
        this.parcelleGrounds.add(ground);

        // Divide parcelle into zones for cultures
        this.calculateZones(data, centerX, centerZ, width, depth);
    }

    calculateZones(data, centerX, centerZ, width, depth) {
        const cultures = data.cultures || [];
        if (cultures.length === 0) return;

        const totalSurface = data.surface;
        let currentX = centerX - width / 2;

        cultures.forEach(culture => {
            const cultureRatio = culture.surface / totalSurface;
            const zoneWidth = width * cultureRatio;
            
            const zone = {
                id: culture.id,
                nom: culture.nom || culture.typeCulture,
                type: culture.typeCulture,
                surface: culture.surface,
                etat: culture.etat,
                growth: culture.growth,
                bounds: {
                    minX: currentX,
                    maxX: currentX + zoneWidth,
                    minZ: centerZ - depth / 2,
                    maxZ: centerZ + depth / 2
                }
            };

            // Visualize Zone Border (Cleaner Minecraft Grid)
            const borderGeo = new THREE.BoxGeometry(zoneWidth, 0.05, depth);
            const borderMat = new THREE.MeshBasicMaterial({ 
                color: this.getCultureColor(culture.typeCulture),
                wireframe: true // Only show the outline for a grid effect
            });
            const border = new THREE.Mesh(borderGeo, borderMat);
            border.position.set(currentX + zoneWidth / 2, 0.01, centerZ);
            this.parcelleGrounds.add(border);

            this.zones.push(zone);
            currentX += zoneWidth;
        });
    }

    getCultureColor(type) {
        const t = type.toLowerCase();
        if (t.includes('blé')) return 0xf59e0b;
        if (t.includes('maïs')) return 0xfacc15;
        if (t.includes('tomate')) return 0xef4444;
        if (t.includes('banane')) return 0xfde047;
        if (t.includes('rose')) return 0x9333ea;
        return 0x10b981;
    }

    checkPlayerZone(px, pz) {
        return this.zones.find(z => 
            px >= z.bounds.minX && px <= z.bounds.maxX &&
            pz >= z.bounds.minZ && pz <= z.bounds.maxZ
        );
    }
}
