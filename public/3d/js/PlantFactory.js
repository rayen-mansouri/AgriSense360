import * as THREE from 'three';

export class PlantFactory {
    constructor() {
        this.geometries = {};
        this.materials = {};
        this.initSharedMaterials();
    }

    initSharedMaterials() {
        this.materials.stalk = new THREE.MeshStandardMaterial({ color: 0x166534, roughness: 0.8 });
        this.materials.wheat = new THREE.MeshStandardMaterial({ color: 0xeab308, roughness: 0.7 });
        this.materials.tomato = new THREE.MeshStandardMaterial({ color: 0xef4444, roughness: 0.5 });
        this.materials.corn = new THREE.MeshStandardMaterial({ color: 0xfacc15, roughness: 0.6 });
        this.materials.leaf = new THREE.MeshStandardMaterial({ color: 0x14532d, roughness: 0.9, side: THREE.DoubleSide });
        this.materials.rose = new THREE.MeshStandardMaterial({ color: 0xdc2626, roughness: 0.4 });
        this.materials.tulip = new THREE.MeshStandardMaterial({ color: 0xa855f7, roughness: 0.5 });
    }

    /**
     * Returns an array of meshes representing a single plant.
     * For InstancedMesh usage, this would normally return geometries/materials pairs.
     * To keep it simple and performant, we return an array of {geo, mat, offset} objects.
     */
    getPlantData(cultureName, growth) {
        const g = growth / 100;
        const type = this.mapCulture(cultureName);
        
        switch (type) {
            case 'wheat': return this.createWheat(g);
            case 'corn': return this.createCorn(g);
            case 'tomato': return this.createTomato(g);
            case 'salad': return this.createSalad(g);
            case 'root': return this.createRoot(g); // Carrot/Potato
            case 'tree': return this.createFruitTree(g, cultureName);
            case 'berry': return this.createBerry(g);
            case 'banana': return this.createBanana(g);
            case 'rose': return this.createRose(g);
            case 'tulip': return this.createTulip(g);
            case 'jasmine': return this.createJasmine(g);
            default: return this.createWheat(g);
        }
    }

    mapCulture(name) {
        const n = name.toLowerCase();
        if (n.includes('blé') || n.includes('avoine') || n.includes('riz')) return 'wheat';
        if (n.includes('maïs')) return 'corn';
        if (n.includes('tomate')) return 'tomato';
        if (n.includes('salade') || n.includes('oignon') || n.includes('lentille')) return 'salad';
        if (n.includes('carotte') || n.includes('pomme de terre')) return 'root';
        if (n.includes('pomme') || n.includes('pêche') || n.includes('orange')) return 'tree';
        if (n.includes('fraise') || n.includes('framboise')) return 'berry';
        if (n.includes('banane')) return 'banana';
        if (n.includes('rosier')) return 'rose';
        if (n.includes('tulipe')) return 'tulip';
        if (n.includes('jasmin') || n.includes('laurier')) return 'jasmine';
        return 'wheat';
    }

    // --- GEOMETRY CREATORS ---

    createWheat(g) {
        const stalk = new THREE.CylinderGeometry(0.015, 0.03, 1.5 * g, 4);
        stalk.translate(0, 0.75 * g, 0);
        const head = new THREE.SphereGeometry(0.06 * g, 4, 4);
        head.translate(0, 1.5 * g, 0);
        return [
            { geo: stalk, mat: this.materials.wheat },
            { geo: head, mat: this.materials.wheat }
        ];
    }

    createCorn(g) {
        const stalk = new THREE.CylinderGeometry(0.08 * g, 0.08 * g, 2.5 * g, 5);
        stalk.translate(0, 1.25 * g, 0);
        const cob = new THREE.CylinderGeometry(0.15 * g, 0.15 * g, 0.8 * g, 6);
        cob.translate(0, 1.8 * g, 0);
        const leaf = new THREE.ConeGeometry(0.5 * g, 1 * g, 3);
        leaf.rotateX(Math.PI/4);
        leaf.translate(0, 1 * g, 0.3 * g);
        return [
            { geo: stalk, mat: this.materials.stalk },
            { geo: cob, mat: this.materials.corn },
            { geo: leaf, mat: this.materials.leaf }
        ];
    }

    createTomato(g) {
        const bush = new THREE.IcosahedronGeometry(0.8 * g, 1);
        bush.translate(0, 0.5 * g, 0);
        const results = [{ geo: bush, mat: this.materials.leaf }];
        for(let i=0; i<6; i++) {
            const tom = new THREE.SphereGeometry(0.1 * g, 6, 6);
            const angle = (i / 6) * Math.PI * 2;
            tom.translate(Math.cos(angle) * 0.6 * g, 0.4 * g + Math.random()*0.4*g, Math.sin(angle) * 0.6 * g);
            results.push({ geo: tom, mat: this.materials.tomato });
        }
        return results;
    }

    createSalad(g) {
        const results = [];
        for(let i=0; i<3; i++) {
            const leaf = new THREE.TorusGeometry(0.3 * g * (1 - i*0.2), 0.1 * g, 8, 16);
            leaf.rotateX(Math.PI/2);
            leaf.translate(0, 0.05 * g * i, 0);
            results.push({ geo: leaf, mat: this.materials.leaf });
        }
        return results;
    }

    createRoot(g) {
        const tuft = new THREE.ConeGeometry(0.1 * g, 0.4 * g, 4);
        tuft.translate(0, 0.2 * g, 0);
        const root = new THREE.ConeGeometry(0.1 * g, 0.3 * g, 4);
        root.rotateX(Math.PI);
        root.translate(0, 0.05 * g, 0);
        return [
            { geo: tuft, mat: this.materials.leaf },
            { geo: root, mat: new THREE.MeshStandardMaterial({ color: 0xea580c }) }
        ];
    }

    createFruitTree(g, name) {
        const trunk = new THREE.CylinderGeometry(0.2 * g, 0.3 * g, 4 * g, 8);
        trunk.translate(0, 2 * g, 0);
        const canopy = new THREE.IcosahedronGeometry(1.5 * g, 1);
        canopy.translate(0, 4.5 * g, 0);
        const fruits = [];
        const color = name.toLowerCase().includes('pomme') ? 0xef4444 : (name.toLowerCase().includes('orange') ? 0xf97316 : 0xfbcfe8);
        const fruitMat = new THREE.MeshStandardMaterial({ color: color });
        for(let i=0; i<10; i++) {
            const f = new THREE.SphereGeometry(0.15 * g, 6, 6);
            const angle = Math.random() * Math.PI * 2;
            const dist = Math.random() * 1.2 * g;
            f.translate(Math.cos(angle)*dist, 4.5 * g + (Math.random()-0.5)*1*g, Math.sin(angle)*dist);
            fruits.push({ geo: f, mat: fruitMat });
        }
        return [
            { geo: trunk, mat: new THREE.MeshStandardMaterial({ color: 0x451a03 }) },
            { geo: canopy, mat: this.materials.leaf },
            ...fruits
        ];
    }

    createBerry(g) {
        const base = new THREE.SphereGeometry(0.4 * g, 8, 8);
        base.scale(1, 0.5, 1);
        base.translate(0, 0.1 * g, 0);
        const fruits = [];
        for(let i=0; i<5; i++) {
            const f = new THREE.SphereGeometry(0.08 * g, 6, 6);
            f.translate((Math.random()-0.5)*0.6*g, 0.2 * g, (Math.random()-0.5)*0.6*g);
            fruits.push({ geo: f, mat: this.materials.tomato });
        }
        return [{ geo: base, mat: this.materials.leaf }, ...fruits];
    }

    createBanana(g) {
        const trunk = new THREE.CylinderGeometry(0.15 * g, 0.25 * g, 3.5 * g, 8);
        trunk.translate(0, 1.75 * g, 0);
        const leaves = [];
        for(let i=0; i<5; i++) {
            const leaf = new THREE.PlaneGeometry(0.8 * g, 2 * g);
            leaf.rotateX(Math.PI/3);
            leaf.rotateY((i/5)*Math.PI*2);
            leaf.translate(0, 3.5 * g, 0);
            leaves.push({ geo: leaf, mat: this.materials.leaf });
        }
        const bunch = new THREE.CylinderGeometry(0.1*g, 0.1*g, 0.6*g, 6);
        bunch.translate(0, 3*g, 0.4*g);
        return [
            { geo: trunk, mat: this.materials.stalk },
            { geo: bunch, mat: this.materials.corn },
            ...leaves
        ];
    }

    createRose(g) {
        const stem = new THREE.CylinderGeometry(0.02*g, 0.02*g, 1*g, 4);
        stem.translate(0, 0.5*g, 0);
        const head = new THREE.SphereGeometry(0.15*g, 8, 8);
        head.translate(0, 1*g, 0);
        const petals = new THREE.RingGeometry(0.1*g, 0.2*g, 8);
        petals.rotateX(-Math.PI/2);
        petals.translate(0, 1.1*g, 0);
        return [
            { geo: stem, mat: this.materials.stalk },
            { geo: head, mat: this.materials.rose },
            { geo: petals, mat: this.materials.rose }
        ];
    }

    createTulip(g) {
        const stem = new THREE.CylinderGeometry(0.02*g, 0.02*g, 0.8*g, 4);
        stem.translate(0, 0.4*g, 0);
        const cup = new THREE.ConeGeometry(0.1*g, 0.2*g, 6);
        cup.translate(0, 0.9*g, 0);
        return [
            { geo: stem, mat: this.materials.stalk },
            { geo: cup, mat: this.materials.tulip }
        ];
    }

    createJasmine(g) {
        const bush = new THREE.IcosahedronGeometry(0.5 * g, 1);
        bush.translate(0, 0.3 * g, 0);
        const flowers = [];
        const whiteMat = new THREE.MeshStandardMaterial({ color: 0xffffff });
        for(let i=0; i<12; i++) {
            const f = new THREE.SphereGeometry(0.03 * g, 4, 4);
            const angle = Math.random() * Math.PI * 2;
            const dist = 0.4 * g;
            f.translate(Math.cos(angle)*dist, 0.2*g + Math.random()*0.4*g, Math.sin(angle)*dist);
            flowers.push({ geo: f, mat: whiteMat });
        }
        return [{ geo: bush, mat: this.materials.leaf }, ...flowers];
    }
}
