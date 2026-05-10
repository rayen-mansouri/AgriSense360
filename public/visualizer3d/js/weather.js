import * as THREE from 'three';

export class WeatherSystem {
    constructor(scene) {
        this.scene = scene;
        this.systems = []; // Array of {type, mesh, count, bounds}
    }

    /**
     * Create weather effect centered at x, z covering width/depth.
     */
    addLocalWeather(type, x, z, w, d) {
        if (type === 'pluie' || type === 'orage') {
            this.createRain(x, z, w, d, type === 'orage');
        } else if (type === 'soleil') {
            this.createSunGlow(x, z, w, d);
        }
    }

    createRain(x, z, w, d, isStorm) {
        const count = isStorm ? 2000 : 800;
        const geo = new THREE.BufferGeometry();
        const positions = new Float32Array(count * 3);
        const velocities = new Float32Array(count);

        for (let i = 0; i < count; i++) {
            positions[i*3] = x + (Math.random()-0.5) * w;
            positions[i*3+1] = Math.random() * 50;
            positions[i*3+2] = z + (Math.random()-0.5) * d;
            velocities[i] = 0.5 + Math.random();
        }

        geo.setAttribute('position', new THREE.BufferAttribute(positions, 3));
        const mat = new THREE.PointsMaterial({
            color: 0x88ccff,
            size: 0.1,
            transparent: true,
            opacity: 0.6
        });

        const points = new THREE.Points(geo, mat);
        this.scene.add(points);
        
        let lightning = null;
        if (isStorm) {
            lightning = new THREE.PointLight(0xffffff, 0, 100);
            lightning.position.set(x, 40, z);
            this.scene.add(lightning);
        }

        this.systems.push({
            type: isStorm ? 'orage' : 'pluie',
            mesh: points,
            velocities: velocities,
            bounds: { x, z, w, d, minH: 0, maxH: 50 },
            lightning: lightning,
            nextFlash: Math.random() * 5
        });
    }

    createSunGlow(x, z, w, d) {
        const light = new THREE.PointLight(0xffddaa, 2, 80);
        light.position.set(x, 20, z);
        this.scene.add(light);
        
        this.systems.push({ type: 'soleil', light: light, x, z });
    }

    animate(delta, time) {
        this.systems.forEach(s => {
            if (s.type === 'pluie' || s.type === 'orage') {
                const pos = s.mesh.geometry.attributes.position.array;
                for (let i = 0; i < s.velocities.length; i++) {
                    pos[i*3+1] -= s.velocities[i] * delta * 100;
                    if (pos[i*3+1] < 0) {
                        pos[i*3+1] = s.bounds.maxH;
                    }
                }
                s.mesh.geometry.attributes.position.needsUpdate = true;

                if (s.type === 'orage' && s.lightning) {
                    s.nextFlash -= delta;
                    if (s.nextFlash < 0) {
                        s.lightning.intensity = 5;
                        setTimeout(() => s.lightning.intensity = 0, 50);
                        setTimeout(() => s.lightning.intensity = 3, 100);
                        setTimeout(() => s.lightning.intensity = 0, 200);
                        s.nextFlash = 3 + Math.random() * 5;
                    }
                }
            } else if (s.type === 'soleil') {
                s.light.intensity = 1.5 + Math.sin(time * 2) * 0.5;
            }
        });
    }
}
