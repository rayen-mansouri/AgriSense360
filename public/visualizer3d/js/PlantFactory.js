import * as THREE from 'three';

export class PlantFactory {
    constructor() {
        this.materials = this.initMaterials();
        this.shapes = this.initShapes();
    }

    initMaterials() {
        return {
            stalk: new THREE.MeshStandardMaterial({ color: 0x8fad3c, roughness: 0.8 }),
            leaf: new THREE.MeshStandardMaterial({ color: 0x2d7d2d, roughness: 0.9, side: THREE.DoubleSide }),
            wheatHead: new THREE.MeshStandardMaterial({ color: 0xd4a017, roughness: 0.7 }),
            cornStalk: new THREE.MeshStandardMaterial({ color: 0x2d6e2d, roughness: 0.8 }),
            cornCob: new THREE.MeshStandardMaterial({ color: 0xf5c842, roughness: 0.6 }),
            tomatoBush: new THREE.MeshStandardMaterial({ color: 0x1a5c1a, roughness: 0.9 }),
            tomatoRed: new THREE.MeshPhongMaterial({ color: 0xe8270a, shininess: 80 }),
            tomatoGreen: new THREE.MeshPhongMaterial({ color: 0x5aaa2a, shininess: 40 }),
            strawberry: new THREE.MeshPhongMaterial({ color: 0xe8001a, shininess: 100 }),
            raspberry: new THREE.MeshPhongMaterial({ color: 0xcc1144, shininess: 120 }),
            banana: new THREE.MeshPhongMaterial({ color: 0xffe135, shininess: 60 }),
            jasmine: new THREE.MeshStandardMaterial({ color: 0xffffff, roughness: 0.3 }),
            rosePetal: new THREE.MeshStandardMaterial({ color: 0xff1a4b, roughness: 0.5, side: THREE.DoubleSide, emissive: 0x330011, emissiveIntensity: 0.2 }),
            roseBud: new THREE.MeshStandardMaterial({ color: 0x8b0000, roughness: 0.8 }),
            bark: new THREE.MeshStandardMaterial({ color: 0x5c3317, roughness: 0.9 }),
            onion: new THREE.MeshStandardMaterial({ color: 0xf0f0e0, roughness: 0.6 })
        };
    }

    initShapes() {
        const heart = new THREE.Shape();
        heart.moveTo(0, 0.1);
        heart.bezierCurveTo(0, 0.2, 0.15, 0.2, 0.15, 0.08);
        heart.bezierCurveTo(0.15, -0.05, 0, -0.1, 0, -0.15);
        heart.bezierCurveTo(0, -0.1, -0.15, -0.05, -0.15, 0.08);
        heart.bezierCurveTo(-0.15, 0.2, 0, 0.2, 0, 0.1);

        const oval = new THREE.Shape();
        oval.absellipse(0, 0, 0.1, 0.2, 0, Math.PI * 2, false, 0);

        const petal = new THREE.Shape();
        petal.moveTo(0, 0);
        petal.bezierCurveTo(0.1, 0.05, 0.1, 0.2, 0, 0.3);
        petal.bezierCurveTo(-0.1, 0.2, -0.1, 0.05, 0, 0);

        return { heart, oval, petal };
    }

    getPlantData(cultureName, growth, id = 0) {
        const g = Math.max(0.1, growth / 100);
        const type = this.mapCulture(cultureName);
        let group;

        switch (type) {
            case 'wheat': group = this.createWheat(g); break;
            case 'corn': group = this.createCorn(g); break;
            case 'tomato': group = this.createTomato(g); break;
            case 'strawberry': group = this.createStrawberry(g); break;
            case 'raspberry': group = this.createRaspberry(g); break;
            case 'banana': group = this.createBanana(g); break;
            case 'rose': group = this.createRose(g); break;
            case 'tulip': group = this.createTulip(g, id); break;
            case 'jasmine': group = this.createJasmine(g); break;
            case 'tree': group = this.createFruitTree(g, cultureName); break;
            case 'root': group = this.createRootCrop(g, cultureName); break;
            case 'salad': group = this.createSalad(g); break;
            default: group = this.createWheat(g);
        }

        group.userData = {
            windSeed: Math.random() * 100,
            windStrength: 0.1 + Math.random() * 0.2,
            type: cultureName
        };
        return group;
    }

    mapCulture(name) {
        const n = name.toLowerCase();
        if (n.includes('blé') || n.includes('avoine') || n.includes('riz')) return 'wheat';
        if (n.includes('maïs')) return 'corn';
        if (n.includes('tomate')) return 'tomato';
        if (n.includes('fraise')) return 'strawberry';
        if (n.includes('framboise')) return 'raspberry';
        if (n.includes('banane')) return 'banana';
        if (n.includes('rose')) return 'rose';
        if (n.includes('tulipe')) return 'tulip';
        if (n.includes('jasmin') || n.includes('laurier')) return 'jasmine';
        if (n.includes('pomme') || n.includes('pêche') || n.includes('orange')) return 'tree';
        if (n.includes('pomme de terre') || n.includes('oignon') || n.includes('lentille')) return 'root';
        if (n.includes('salade')) return 'salad';
        return 'wheat';
    }

    // --- PLANT GENERATORS ---

    createWheat(g) {
        const group = new THREE.Group();
        const height = 1.2 * g;
        const stalkGeo = new THREE.CylinderGeometry(0.015, 0.025, height, 4);
        stalkGeo.translate(0, height / 2, 0);
        const stalk = new THREE.Mesh(stalkGeo, this.materials.stalk);
        stalk.castShadow = true;
        group.add(stalk);

        const headGeo = new THREE.SphereGeometry(0.06, 6, 4);
        headGeo.scale(1, 2, 1);
        headGeo.translate(0, height, 0);
        const head = new THREE.Mesh(headGeo, this.materials.wheatHead);
        head.castShadow = true;
        group.add(head);

        for (let i = 0; i < 3; i++) {
            const leafGeo = new THREE.PlaneGeometry(0.1, 0.4);
            leafGeo.translate(0, 0.2, 0);
            const leaf = new THREE.Mesh(leafGeo, this.materials.leaf);
            leaf.position.y = height * (0.3 + i * 0.2);
            leaf.rotation.x = 0.8;
            leaf.rotation.y = i * 2;
            leaf.castShadow = true;
            group.add(leaf);
        }
        return group;
    }

    createCorn(g) {
        const group = new THREE.Group();
        const height = 2.8 * g;
        const stalk = new THREE.Mesh(new THREE.CylinderGeometry(0.04, 0.06, height, 6), this.materials.cornStalk);
        stalk.position.y = height / 2;
        stalk.castShadow = true;
        group.add(stalk);

        for (let i = 0; i < 4; i++) {
            const leaf = new THREE.Mesh(new THREE.PlaneGeometry(0.15, 1.0), this.materials.leaf);
            leaf.position.y = height * (0.2 + i * 0.2);
            leaf.rotation.x = 1.2;
            leaf.rotation.y = i * 1.5;
            leaf.castShadow = true;
            group.add(leaf);
        }

        if (g > 0.5) {
            const cob = new THREE.Mesh(new THREE.CylinderGeometry(0.08, 0.08, 0.5, 8), this.materials.cornCob);
            cob.position.y = height * 0.6;
            cob.rotation.z = 0.2;
            cob.castShadow = true;
            group.add(cob);
        }
        return group;
    }

    createTomato(g) {
        const group = new THREE.Group();
        const height = 1.0 * g;
        const stalk = new THREE.Mesh(new THREE.CylinderGeometry(0.02, 0.02, height, 4), this.materials.cornStalk);
        stalk.position.y = height / 2;
        group.add(stalk);

        for (let i = 0; i < 3; i++) {
            const bush = new THREE.Mesh(new THREE.SphereGeometry(0.25 * g, 8, 6), this.materials.tomatoBush);
            bush.scale.set(1.2, 0.8, 1);
            bush.position.y = height * (0.4 + i * 0.2);
            bush.position.x = (Math.random() - 0.5) * 0.2;
            bush.castShadow = true;
            group.add(bush);
        }

        const count = Math.floor(10 * g);
        const mat = g > 0.5 ? this.materials.tomatoRed : this.materials.tomatoGreen;
        for (let i = 0; i < count; i++) {
            const tomGroup = new THREE.Group();
            const tom = new THREE.Mesh(new THREE.SphereGeometry(0.07, 10, 8), mat);
            tomGroup.add(tom);
            const stem = new THREE.Mesh(new THREE.CylinderGeometry(0.005, 0.005, 0.04), this.materials.cornStalk);
            stem.position.y = 0.07;
            tomGroup.add(stem);

            const angle = Math.random() * Math.PI * 2;
            const radius = 0.2 * g;
            tomGroup.position.set(Math.cos(angle) * radius, height * (0.3 + Math.random() * 0.5), Math.sin(angle) * radius);
            tomGroup.castShadow = true;
            group.add(tomGroup);
        }
        return group;
    }

    createStrawberry(g) {
        const group = new THREE.Group();
        // Leaves
        for (let i = 0; i < 6; i++) {
            const leaf = new THREE.Mesh(new THREE.ShapeGeometry(this.shapes.heart), this.materials.leaf);
            leaf.rotation.x = -Math.PI / 2.5;
            leaf.rotation.z = (i / 6) * Math.PI * 2;
            leaf.scale.set(g, g, g);
            leaf.castShadow = true;
            group.add(leaf);
        }
        // Fruit
        if (g > 0.4) {
            const pts = [
                new THREE.Vector2(0, 0),
                new THREE.Vector2(0.06, 0.04),
                new THREE.Vector2(0.07, 0.09),
                new THREE.Vector2(0.05, 0.13),
                new THREE.Vector2(0, 0.16)
            ];
            const fruitGeo = new THREE.LatheGeometry(pts, 12);
            fruitGeo.rotateX(Math.PI);
            const fruit = new THREE.Mesh(fruitGeo, this.materials.strawberry);
            fruit.position.set(0.15 * g, 0.1 * g, 0);
            fruit.castShadow = true;
            group.add(fruit);
            
            // Tiny seeds
            for(let i=0; i<8; i++) {
                const seed = new THREE.Mesh(new THREE.SphereGeometry(0.005, 4, 4), new THREE.MeshStandardMaterial({color: 0xffffff}));
                const phi = Math.random() * Math.PI;
                const theta = Math.random() * Math.PI * 2;
                seed.position.setFromSphericalCoords(0.06, phi, theta);
                seed.position.y -= 0.1; // Offset for inverted lathe
                fruit.add(seed);
            }
        }
        return group;
    }

    createRaspberry(g) {
        const group = new THREE.Group();
        const bush = new THREE.Mesh(new THREE.IcosahedronGeometry(0.2 * g, 1), this.materials.tomatoBush);
        bush.position.y = 0.2 * g;
        group.add(bush);

        if (g > 0.5) {
            const berryGroup = new THREE.Group();
            for (let i = 0; i < 12; i++) {
                const s = new THREE.Mesh(new THREE.SphereGeometry(0.025, 6, 4), this.materials.raspberry);
                const phi = Math.acos(-1 + (2 * i) / 12);
                const theta = Math.sqrt(12 * Math.PI) * phi;
                s.position.setFromSphericalCoords(0.06, phi, theta);
                berryGroup.add(s);
            }
            berryGroup.position.set(0.2 * g, 0.3 * g, 0);
            group.add(berryGroup);
        }
        return group;
    }

    createBanana(g) {
        const group = new THREE.Group();
        const height = 3.5 * g;
        const trunk = new THREE.Mesh(new THREE.CylinderGeometry(0.12, 0.18, height, 8), this.materials.stalk);
        trunk.position.y = height / 2;
        group.add(trunk);

        for (let i = 0; i < 6; i++) {
            const leaf = new THREE.Mesh(new THREE.PlaneGeometry(0.3, 1.8 * g), this.materials.leaf);
            leaf.position.y = height;
            leaf.rotation.y = (i / 6) * Math.PI * 2;
            leaf.rotation.x = 0.4;
            leaf.castShadow = true;
            group.add(leaf);
        }

        if (g > 0.6) {
            const pts = [new THREE.Vector2(0, 0), new THREE.Vector2(0.04, 0.05), new THREE.Vector2(0.05, 0.12), new THREE.Vector2(0.03, 0.18), new THREE.Vector2(0, 0.2)];
            const bBunch = new THREE.Group();
            for (let i = 0; i < 6; i++) {
                const b = new THREE.Mesh(new THREE.LatheGeometry(pts, 12), this.materials.banana);
                b.rotation.y = (i / 6) * Math.PI * 2;
                b.position.x = 0.15;
                bBunch.add(b);
            }
            bBunch.position.y = height * 0.7;
            group.add(bBunch);
        }
        return group;
    }

    createRose(g) {
        const group = new THREE.Group();
        const height = 1.2 * g;
        const stem = new THREE.Mesh(new THREE.CylinderGeometry(0.015, 0.02, height, 5), this.materials.cornStalk);
        stem.position.y = height / 2;
        group.add(stem);

        if (g < 0.4) {
            const bud = new THREE.Mesh(new THREE.SphereGeometry(0.05), this.materials.roseBud);
            bud.position.y = height;
            group.add(bud);
        } else {
            const flower = new THREE.Group();
            for (let i = 0; i < 16; i++) {
                const p = new THREE.Mesh(new THREE.ShapeGeometry(this.shapes.petal), this.materials.rosePetal);
                p.rotation.y = i * 2.399; // Fibonacci angle
                p.rotation.x = 0.5 + (i * 0.05);
                const scale = 1 - (i * 0.03);
                p.scale.set(scale, scale, scale);
                flower.add(p);
            }
            flower.position.y = height;
            group.add(flower);
        }
        return group;
    }

    createTulip(g, id) {
        const group = new THREE.Group();
        const height = 0.8 * g;
        const stem = new THREE.Mesh(new THREE.CylinderGeometry(0.01, 0.015, height, 4), this.materials.stalk);
        stem.position.y = height / 2;
        group.add(stem);

        const colors = [0xff2200, 0xffcc00, 0xcc00ff, 0xff6699];
        const tulipMat = new THREE.MeshStandardMaterial({ color: colors[id % 4], roughness: 0.5, side: THREE.DoubleSide });
        
        const cup = new THREE.Group();
        for (let i = 0; i < 6; i++) {
            const p = new THREE.Mesh(new THREE.ShapeGeometry(this.shapes.petal), tulipMat);
            p.rotation.y = (i / 6) * Math.PI * 2;
            p.rotation.x = -0.8 + (g * 1.0); // Opens with growth
            cup.add(p);
        }
        cup.position.y = height;
        group.add(cup);
        return group;
    }

    createJasmine(g) {
        const group = new THREE.Group();
        const bush = new THREE.Mesh(new THREE.IcosahedronGeometry(0.3 * g, 2), this.materials.tomatoBush);
        bush.position.y = 0.3 * g;
        bush.scale.y = 0.7;
        group.add(bush);

        const flowerCount = Math.floor(20 * g);
        for (let i = 0; i < flowerCount; i++) {
            const f = new THREE.Mesh(new THREE.SphereGeometry(0.03, 6, 4), this.materials.jasmine);
            const phi = Math.random() * Math.PI;
            const theta = Math.random() * Math.PI * 2;
            f.position.setFromSphericalCoords(0.3 * g, phi, theta);
            group.add(f);
        }
        return group;
    }

    createFruitTree(g, name) {
        const group = new THREE.Group();
        const height = 3.5 * g;
        const trunk = new THREE.Mesh(new THREE.CylinderGeometry(0.15, 0.22, height, 8), this.materials.bark);
        trunk.position.y = height / 2;
        group.add(trunk);

        const canopy = new THREE.Group();
        for(let i=0; i<4; i++) {
            const c = new THREE.Mesh(new THREE.IcosahedronGeometry(1.2 * g, 1), this.materials.tomatoBush);
            c.position.set((Math.random()-0.5)*1*g, height + i*0.5*g, (Math.random()-0.5)*1*g);
            c.scale.set(1.2, 0.8, 1);
            canopy.add(c);
        }
        group.add(canopy);

        if (g > 0.6) {
            let color = 0xe8001a;
            if (name.toLowerCase().includes('orange')) color = 0xff6600;
            if (name.toLowerCase().includes('pêche')) color = 0xffaa44;
            const fruitMat = new THREE.MeshPhongMaterial({ color: color, shininess: 90 });
            for (let i = 0; i < 12; i++) {
                const f = new THREE.Mesh(new THREE.SphereGeometry(0.1, 10, 8), fruitMat);
                const angle = Math.random() * Math.PI * 2;
                const dist = 1.2 * g;
                f.position.set(Math.cos(angle) * dist, height + Math.random() * 2 * g, Math.sin(angle) * dist);
                group.add(f);
            }
        }
        return group;
    }

    createRootCrop(g, name) {
        const group = new THREE.Group();
        const n = name.toLowerCase();
        // Tuft
        for (let i = 0; i < 5; i++) {
            const leaf = new THREE.Mesh(new THREE.PlaneGeometry(0.15, 0.4 * g), this.materials.leaf);
            leaf.rotation.y = (i / 5) * Math.PI * 2;
            leaf.rotation.x = 0.5;
            group.add(leaf);
        }
        if (n.includes('oignon')) {
            const bulb = new THREE.Mesh(new THREE.SphereGeometry(0.15, 8, 6), this.materials.onion);
            bulb.scale.y = 0.6;
            group.add(bulb);
        }
        return group;
    }

    createSalad(g) {
        const group = new THREE.Group();
        for (let i = 0; i < 10; i++) {
            const shape = new THREE.Shape();
            shape.absellipse(0, 0, 0.3 * g, 0.4 * g, 0, Math.PI * 2, false, 0);
            const leaf = new THREE.Mesh(new THREE.ShapeGeometry(shape), this.materials.leaf);
            leaf.rotation.x = -Math.PI / 2 + 0.2;
            leaf.rotation.z = (i / 10) * Math.PI * 2;
            leaf.position.y = i * 0.02;
            group.add(leaf);
        }
        return group;
    }
}
