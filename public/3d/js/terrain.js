import * as THREE from 'three';
import SimplexNoise from 'simplex-noise';

export class TerrainSystem {
    constructor(scene) {
        this.scene = scene;
        this.simplex = new SimplexNoise();
        this.parcelleGrounds = new THREE.Group();
        this.scene.add(this.parcelleGrounds);
    }

    createParcelleGround(data, centerX, centerZ, width, depth) {
        const type = data.typeSol.toLowerCase();
        let geo, mat;

        if (type.includes('sableux')) {
            // Small dunes
            geo = new THREE.PlaneGeometry(width, depth, 64, 64);
            const pos = geo.attributes.position.array;
            for(let i=0; i<pos.length; i+=3) {
                pos[i+2] = this.simplex.noise2D(pos[i]*0.1, pos[i+1]*0.1) * 2;
            }
            geo.computeVertexNormals();
            mat = new THREE.MeshStandardMaterial({ color: 0xc2a05a, roughness: 1.0 });
            this.addSandParticles(centerX, centerZ, width, depth);
        } else if (type.includes('argileux')) {
            // Flat with cracks
            geo = new THREE.PlaneGeometry(width, depth);
            mat = new THREE.MeshStandardMaterial({ color: 0x5c3a1e, roughness: 0.9 });
            this.addCracks(centerX, centerZ, width, depth);
        } else if (type.includes('limoneux')) {
            // Bumpy rich soil
            geo = new THREE.PlaneGeometry(width, depth, 32, 32);
            const pos = geo.attributes.position.array;
            for(let i=0; i<pos.length; i+=3) {
                pos[i+2] = this.simplex.noise2D(pos[i]*0.05, pos[i+1]*0.05) * 0.5;
            }
            geo.computeVertexNormals();
            mat = new THREE.MeshStandardMaterial({ color: 0x4a3728, roughness: 0.8 });
        } else if (type.includes('calcaire')) {
            // Rocky grey
            geo = new THREE.PlaneGeometry(width, depth);
            mat = new THREE.MeshStandardMaterial({ color: 0xd4cfc7, roughness: 0.9 });
            this.addStones(centerX, centerZ, width, depth);
        } else {
            geo = new THREE.PlaneGeometry(width, depth);
            mat = new THREE.MeshStandardMaterial({ color: 0x3d4a2a, roughness: 0.9 });
        }

        const mesh = new THREE.Mesh(geo, mat);
        mesh.rotation.x = -Math.PI / 2;
        mesh.position.set(centerX, 0.05, centerZ);
        mesh.receiveShadow = true;
        mesh.userData = { isGround: true, data: data };
        this.parcelleGrounds.add(mesh);

        // Glowing border
        const borderGeo = new THREE.BoxGeometry(width, 0.2, depth);
        const edges = new THREE.EdgesGeometry(borderGeo);
        const lineMat = new THREE.LineBasicMaterial({ color: this.getCultureColor(data.cultures) });
        const line = new THREE.LineSegments(edges, lineMat);
        line.position.set(centerX, 0.1, centerZ);
        this.parcelleGrounds.add(line);
    }

    getCultureColor(cultures) {
        if (!cultures || cultures.length === 0) return 0x10b981;
        const name = cultures[0].typeCulture.toLowerCase();
        if (name.includes('blé')) return 0xf59e0b;
        if (name.includes('maïs')) return 0x22c55e;
        if (name.includes('tomate')) return 0xef4444;
        if (name.includes('tournesol')) return 0xeab308;
        if (name.includes('rose')) return 0xa855f7;
        return 0x10b981;
    }

    addSandParticles(x, z, w, d) {
        const geo = new THREE.SphereGeometry(0.02, 4, 4);
        const mat = new THREE.MeshStandardMaterial({ color: 0xd4b483 });
        const mesh = new THREE.InstancedMesh(geo, mat, 500);
        const dummy = new THREE.Object3D();
        for(let i=0; i<500; i++) {
            dummy.position.set(x + (Math.random()-0.5)*w, 0.1, z + (Math.random()-0.5)*d);
            dummy.updateMatrix();
            mesh.setMatrixAt(i, dummy.matrix);
        }
        this.parcelleGrounds.add(mesh);
    }

    addCracks(x, z, w, d) {
        // Overlay a few dark lines to simulate dry soil
        const crackMat = new THREE.LineBasicMaterial({ color: 0x2a1a0d, transparent: true, opacity: 0.5 });
        for(let i=0; i<10; i++) {
            const points = [];
            let px = x + (Math.random()-0.5)*w;
            let pz = z + (Math.random()-0.5)*d;
            for(let j=0; j<5; j++) {
                points.push(new THREE.Vector3(px, 0.1, pz));
                px += (Math.random()-0.5)*2;
                pz += (Math.random()-0.5)*2;
            }
            const geo = new THREE.BufferGeometry().setFromPoints(points);
            const line = new THREE.Line(geo, crackMat);
            this.parcelleGrounds.add(line);
        }
    }

    addStones(x, z, w, d) {
        const geo = new THREE.DodecahedronGeometry(0.2, 0);
        const mat = new THREE.MeshStandardMaterial({ color: 0x94a3b8 });
        const mesh = new THREE.InstancedMesh(geo, mat, 50);
        const dummy = new THREE.Object3D();
        for(let i=0; i<50; i++) {
            dummy.position.set(x + (Math.random()-0.5)*w, 0.1, z + (Math.random()-0.5)*d);
            dummy.rotation.set(Math.random(), Math.random(), Math.random());
            dummy.scale.setScalar(0.5 + Math.random());
            dummy.updateMatrix();
            mesh.setMatrixAt(i, dummy.matrix);
        }
        this.parcelleGrounds.add(mesh);
    }
}
