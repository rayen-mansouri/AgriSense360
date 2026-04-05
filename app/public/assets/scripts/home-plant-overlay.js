(function () {
    const overlay = document.getElementById('plant-intro-overlay');
    const canvas = document.getElementById('plant-intro-canvas');
    const body = document.body;
    const title = document.getElementById('plant-intro-title');
    const subtitle = document.getElementById('plant-intro-sub');
    const panelConfigs = [
        { element: document.getElementById('plant-panel-left-a'), start: 0.26, end: 0.4, phase: 0.4, side: -1 },
        { element: document.getElementById('plant-panel-left-b'), start: 0.34, end: 0.48, phase: 1.1, side: -1 },
        { element: document.getElementById('plant-panel-left-c'), start: 0.42, end: 0.56, phase: 1.8, side: -1 },
        { element: document.getElementById('plant-panel-right-a'), start: 0.3, end: 0.44, phase: 0.7, side: 1 },
        { element: document.getElementById('plant-panel-right-b'), start: 0.38, end: 0.52, phase: 1.45, side: 1 },
        { element: document.getElementById('plant-panel-right-c'), start: 0.46, end: 0.6, phase: 2.15, side: 1 },
    ].filter(function (item) { return !!item.element; });
    const progressFill = document.getElementById('plant-intro-fill');
    const progressText = document.getElementById('plant-intro-text');

    if (!overlay || !canvas) {
        return;
    }

    let finished = false;
    let progress = 0;
    let targetProgress = 0;
    let touchStartY = null;

    function clamp(value) {
        return Math.max(0, Math.min(1, value));
    }

    function easeOut(t) {
        return 1 - Math.pow(1 - t, 3);
    }

    function band(localProgress, start, end) {
        return easeOut(clamp((localProgress - start) / (end - start)));
    }

    function lockPage() {
        body.classList.add('intro-locked');
        window.scrollTo(0, 0);
    }

    function unlockPage() {
        body.classList.remove('intro-locked');
    }

    function increaseProgress(delta) {
        if (finished) {
            return;
        }

        const amount = delta > 0 ? delta * 0.001 : delta * 0.00045;
        targetProgress = clamp(targetProgress + amount);
    }

    function onWheel(event) {
        if (finished) {
            return;
        }

        event.preventDefault();
        increaseProgress(event.deltaY);
    }

    function onKeyDown(event) {
        if (finished) {
            return;
        }

        const scrollingKeys = ['ArrowDown', 'PageDown', 'Space', 'ArrowUp', 'PageUp'];
        if (scrollingKeys.indexOf(event.code) === -1 && scrollingKeys.indexOf(event.key) === -1) {
            return;
        }

        event.preventDefault();
        if (event.key === 'ArrowUp' || event.key === 'PageUp') {
            increaseProgress(-80);
        } else {
            increaseProgress(120);
        }
    }

    function onTouchStart(event) {
        if (finished || event.touches.length === 0) {
            return;
        }

        touchStartY = event.touches[0].clientY;
    }

    function onTouchMove(event) {
        if (finished || event.touches.length === 0 || touchStartY === null) {
            return;
        }

        const currentY = event.touches[0].clientY;
        const deltaY = touchStartY - currentY;

        if (Math.abs(deltaY) > 1) {
            event.preventDefault();
            increaseProgress(deltaY);
            touchStartY = currentY;
        }
    }

    function onTouchEnd() {
        touchStartY = null;
    }

    function onScroll() {
        if (!finished) {
            window.scrollTo(0, 0);
        }
    }

    function detachLockEvents() {
        window.removeEventListener('wheel', onWheel, { passive: false });
        window.removeEventListener('keydown', onKeyDown, { passive: false });
        window.removeEventListener('touchstart', onTouchStart, { passive: false });
        window.removeEventListener('touchmove', onTouchMove, { passive: false });
        window.removeEventListener('touchend', onTouchEnd, { passive: false });
        window.removeEventListener('scroll', onScroll, { passive: true });
    }

    function completeIntro() {
        if (finished) {
            return;
        }

        finished = true;
        progress = 1;
        targetProgress = 1;
        overlay.classList.add('is-complete');
        detachLockEvents();
        unlockPage();

        window.setTimeout(function () {
            overlay.style.display = 'none';
        }, 900);
    }

    function updateOverlayUi() {
        progress += (targetProgress - progress) * 0.12;
        progress = clamp(progress);

        if (progressFill) {
            progressFill.style.width = String(progress * 100) + '%';
        }

        if (progressText) {
            progressText.textContent = progress < 0.2
                ? 'scroll to grow'
                : progress < 0.45
                    ? 'sprouting...'
                    : progress < 0.75
                        ? 'growing...'
                        : 'almost ready';
        }

        const logoFade = 1 - clamp((progress - 0.06) / 0.45);
        if (title) {
            title.style.opacity = String(logoFade);
            title.style.transform = 'translate(-50%, -50%) scale(' + (1 + (1 - logoFade) * 0.06) + ')';
        }

        if (subtitle) {
            const subtitleReveal = band(progress, 0.08, 0.24);
            subtitle.style.opacity = String(subtitleReveal * logoFade * 0.9);
        }

        if (progress >= 0.995) {
            completeIntro();
        }
    }

    function updatePanelMotion(elapsed) {
        for (let i = 0; i < panelConfigs.length; i += 1) {
            const config = panelConfigs[i];
            const panel = config.element;
            const reveal = band(progress, config.start, config.end);
            const floatY = Math.sin(elapsed * 1.6 + config.phase) * 4;
            const driftX = Math.cos(elapsed * 1.25 + config.phase) * 3 * config.side;
            const rotate = Math.sin(elapsed * 1.35 + config.phase) * 0.8;
            const offsetY = 10 - reveal * 10;
            const middleBase = panel.classList.contains('middle') ? -50 : 0;

            panel.style.opacity = String(reveal);
            panel.style.transform =
                'translate3d(' + (driftX * reveal) + 'px, calc(' + middleBase + '% + ' + (offsetY + floatY * reveal) + 'px), 0) rotate(' + (rotate * reveal) + 'deg)';

            if (reveal > 0.12) {
                panel.classList.add('is-visible');
            } else {
                panel.classList.remove('is-visible');
            }
        }
    }

    if (typeof THREE === 'undefined') {
        completeIntro();
        return;
    }

    const renderer = new THREE.WebGLRenderer({ canvas: canvas, antialias: true, alpha: true });
    renderer.setPixelRatio(Math.min(window.devicePixelRatio || 1, 2));
    renderer.outputEncoding = THREE.sRGBEncoding;
    renderer.toneMapping = THREE.ACESFilmicToneMapping;
    renderer.toneMappingExposure = 1.18;

    const scene = new THREE.Scene();
    const camera = new THREE.PerspectiveCamera(40, 1, 0.1, 100);
    camera.position.set(0, 3.3, 11);
    camera.lookAt(0, 2.1, 0);

    const hemi = new THREE.HemisphereLight(0xb8d8f5, 0x4a3a08, 0.72);
    scene.add(hemi);

    const sun = new THREE.DirectionalLight(0xfff8e0, 2.2);
    sun.position.set(9, 18, 9);
    scene.add(sun);

    const fill = new THREE.DirectionalLight(0xc5e0ff, 0.52);
    fill.position.set(-7, 5, -5);
    scene.add(fill);

    const soilMat = new THREE.MeshStandardMaterial({ color: 0x4a2c0c, roughness: 0.92, metalness: 0, transparent: true, opacity: 0 });
    const soil = new THREE.Mesh(new THREE.CylinderGeometry(4, 4.2, 0.28, 56), soilMat);
    soil.position.y = -0.14;
    scene.add(soil);

    const topSoilMat = new THREE.MeshStandardMaterial({ color: 0x5a3614, roughness: 0.9, metalness: 0, transparent: true, opacity: 0 });
    const topSoil = new THREE.Mesh(
        new THREE.CylinderGeometry(3.9, 3.9, 0.03, 48),
        topSoilMat
    );
    topSoil.position.y = 0.02;
    scene.add(topSoil);

    function makeLeaf(length, width, color) {
        const geometry = new THREE.PlaneGeometry(width, length, 4, 12);
        const position = geometry.attributes.position;

        for (let i = 0; i < position.count; i += 1) {
            const y = position.getY(i);
            const bend = (y / length) * (y / length) * 0.26;
            const x = position.getX(i);
            position.setZ(i, bend + Math.abs(x) * 0.04);
        }

        geometry.computeVertexNormals();

        const material = new THREE.MeshStandardMaterial({
            color: color,
            side: THREE.DoubleSide,
            roughness: 0.62,
            metalness: 0,
        });

        const mesh = new THREE.Mesh(geometry, material);
        mesh.position.y = length * 0.5;
        return mesh;
    }

    function makeEar() {
        const group = new THREE.Group();
        const material = new THREE.MeshStandardMaterial({ color: 0xd0ac20, roughness: 0.5, metalness: 0.06 });

        for (let i = 0; i < 10; i += 1) {
            const grain = new THREE.Mesh(new THREE.SphereGeometry(0.055, 8, 8), material);
            grain.position.set((i % 2 === 0 ? 1 : -1) * 0.04, i * 0.11, 0.015);
            grain.scale.set(1, 1.6, 1);
            group.add(grain);
        }

        return group;
    }

    function makePlant(offsetX, offsetZ, scaleFactor, phase) {
        const group = new THREE.Group();
        group.position.set(offsetX, 0.14, offsetZ);

        const stemMat = new THREE.MeshStandardMaterial({ color: 0x3c7c1c, roughness: 0.58, metalness: 0 });
        const stem = new THREE.Mesh(new THREE.CylinderGeometry(0.038, 0.05, 3.8 * scaleFactor, 10), stemMat);
        stem.position.y = (3.8 * scaleFactor) * 0.5;
        stem.rotation.z = (phase - 2) * 0.05;
        group.add(stem);

        const leaves = [];
        const leafColors = [0x4f9720, 0x5aa524, 0x3f8619, 0x6bb22c];
        for (let i = 0; i < 6; i += 1) {
            const leafGroup = new THREE.Group();
            const leaf = makeLeaf(0.9 - i * 0.06, 0.18 - i * 0.01, leafColors[i % leafColors.length]);
            leafGroup.add(leaf);
            leafGroup.position.y = 0.45 + i * 0.44;
            leafGroup.rotation.y = phase + i * 1.25;
            leafGroup.rotation.z = (i % 2 === 0 ? 1 : -1) * 0.42;
            leafGroup.scale.setScalar(0);
            leafGroup.userData.phase = Math.random() * Math.PI * 2;
            leaves.push(leafGroup);
            group.add(leafGroup);
        }

        const ear = makeEar();
        ear.position.y = 3.3 * scaleFactor;
        ear.rotation.z = 0.2;
        ear.scale.setScalar(0);
        group.add(ear);

        group.scale.setScalar(0);
        scene.add(group);

        return {
            group: group,
            leaves: leaves,
            ear: ear,
            phase: phase,
        };
    }

    function makeBackdropLeaf(width, height, color, opacity, offsetX, offsetY, offsetZ, rotationZ) {
        const geometry = new THREE.PlaneGeometry(width, height, 4, 10);
        const position = geometry.attributes.position;

        for (let i = 0; i < position.count; i += 1) {
            const y = position.getY(i);
            const curve = Math.sin((y / height) * Math.PI) * 0.12;
            const x = position.getX(i);
            position.setZ(i, curve + Math.abs(x) * 0.03);
        }

        geometry.computeVertexNormals();

        const material = new THREE.MeshStandardMaterial({
            color: color,
            side: THREE.DoubleSide,
            roughness: 0.82,
            metalness: 0,
            transparent: true,
            opacity: opacity,
            depthWrite: false,
        });

        const mesh = new THREE.Mesh(geometry, material);
        mesh.position.set(offsetX, offsetY, offsetZ);
        mesh.rotation.z = rotationZ;
        mesh.userData.baseOpacity = opacity;
        mesh.userData.baseX = offsetX;
        mesh.userData.baseY = offsetY;
        mesh.userData.baseZ = offsetZ;
        mesh.userData.baseRotationZ = rotationZ;
        mesh.userData.floatPhase = Math.random() * Math.PI * 2;
        return mesh;
    }

    const plantSeeds = [
        [0.0, 0.0, 1.0, 0.0],
        [-0.55, 0.2, 0.9, 1.2],
        [0.58, 0.16, 0.92, 2.4],
        [-0.3, -0.46, 0.84, 3.4],
        [0.35, -0.44, 0.86, 4.8],
        [-0.95, -0.08, 0.72, 5.3],
        [0.96, -0.04, 0.74, 5.9],
        [-1.22, 0.34, 0.62, 0.8],
        [1.2, 0.3, 0.64, 1.6],
        [-0.78, -0.78, 0.58, 2.7],
        [0.76, -0.76, 0.6, 3.5],
        [0.02, -0.92, 0.56, 4.2],
    ];

    const miniPlantSeeds = [
        [-1.42, 0.56, 0.36, 0.35],
        [1.46, 0.52, 0.34, 0.92],
        [-1.56, -0.12, 0.32, 1.58],
        [1.58, -0.16, 0.33, 2.24],
        [-1.3, -0.66, 0.3, 3.02],
        [1.28, -0.7, 0.31, 3.68],
        [-0.08, -1.18, 0.28, 4.34],
        [0.14, 0.72, 0.29, 5.06],
    ];

    const allPlantSeeds = plantSeeds.concat(miniPlantSeeds);

    const plants = allPlantSeeds.map(function (seed) {
        return makePlant(seed[0], seed[1], seed[2], seed[3]);
    });

    const backdropLeafSeeds = [
        [-4.9, 1.9, -8.8, -0.42, 1.45, 2.2, 0.14],
        [4.8, 1.8, -8.7, 0.38, 1.36, 2.1, 0.13],
        [-4.3, 0.95, -8.9, -0.18, 1.22, 1.9, 0.12],
        [4.2, 1.05, -8.65, 0.16, 1.18, 1.85, 0.11],
        [-5.05, -0.25, -8.82, 0.22, 1.28, 2.0, 0.12],
        [4.95, -0.28, -8.78, -0.2, 1.25, 1.96, 0.11],
        [-4.1, -1.15, -8.9, -0.14, 1.5, 2.3, 0.1],
        [4.15, -1.08, -8.84, 0.1, 1.46, 2.26, 0.1],
        [-2.8, 1.7, -8.55, -0.34, 1.08, 1.72, 0.09],
        [2.9, 1.62, -8.5, 0.32, 1.1, 1.74, 0.09],
        [-3.0, -1.55, -8.66, 0.28, 1.06, 1.7, 0.08],
        [3.1, -1.48, -8.62, -0.26, 1.04, 1.68, 0.08],
    ];

    const backdropLeaves = backdropLeafSeeds.map(function (seed, index) {
        const palette = [0x3f8619, 0x4f9720, 0x5aa524, 0x6bb22c];
        const leaf = makeBackdropLeaf(seed[4], seed[5], palette[index % palette.length], seed[6], seed[0], seed[1], seed[2], seed[3]);
        leaf.material.opacity = seed[6];
        return leaf;
    });

    const grasses = [];
    for (let i = 0; i < 110; i += 1) {
        const mat = new THREE.MeshStandardMaterial({ color: 0x4a8820, roughness: 0.8, metalness: 0 });
        const blade = new THREE.Mesh(new THREE.CylinderGeometry(0.01, 0.005, 0.45 + Math.random() * 0.35, 5), mat);
        const angle = Math.random() * Math.PI * 2;
        const radius = 0.8 + Math.random() * 2.7;
        blade.position.set(Math.cos(angle) * radius, 0.22, Math.sin(angle) * radius);
        blade.rotation.z = (Math.random() - 0.5) * 0.5;
        blade.rotation.y = Math.random() * Math.PI;
        blade.scale.setScalar(0);
        blade.userData.speed = 0.5 + Math.random() * 0.8;
        blade.userData.phase = Math.random() * Math.PI * 2;
        grasses.push(blade);
        scene.add(blade);
    }

    function resize() {
        renderer.setSize(window.innerWidth, window.innerHeight, false);
        camera.aspect = window.innerWidth / window.innerHeight;
        camera.updateProjectionMatrix();
    }

    function animate() {
        requestAnimationFrame(animate);

        const elapsed = clock.getElapsedTime();
        const windX = Math.sin(elapsed * 0.72) * 0.015 + Math.sin(elapsed * 1.3) * 0.008;
        const windZ = Math.cos(elapsed * 0.84) * 0.01;

        updateOverlayUi();
        updatePanelMotion(elapsed);

        const soilReveal = band(progress, 0.06, 0.2);
        const topSoilReveal = band(progress, 0.09, 0.24);
        soilMat.opacity = soilReveal;
        topSoilMat.opacity = topSoilReveal;
        soil.position.y = -0.16 + soilReveal * 0.02;
        topSoil.position.y = 0.0 + topSoilReveal * 0.02;

        for (let i = 0; i < grasses.length; i += 1) {
            const blade = grasses[i];
            blade.scale.setScalar(band(progress, 0.0, 0.18));
            blade.rotation.x = Math.sin(elapsed * blade.userData.speed + blade.userData.phase) * 0.12 + windX;
            blade.rotation.z = Math.cos(elapsed * blade.userData.speed * 0.7 + blade.userData.phase) * 0.06 + windZ;
        }

        for (let i = 0; i < backdropLeaves.length; i += 1) {
            const leaf = backdropLeaves[i];
            const leafMotion = Math.sin(elapsed * 0.22 + leaf.userData.floatPhase) * 0.02;
            const reveal = band(progress, 0.02, 0.18);

            leaf.rotation.z = leaf.userData.baseRotationZ + leafMotion * 0.14;
            leaf.position.y = leaf.userData.baseY + leafMotion * 0.22;
            leaf.position.x = leaf.userData.baseX + Math.cos(elapsed * 0.16 + leaf.userData.floatPhase) * 0.04;
            leaf.material.opacity = leaf.userData.baseOpacity * reveal;
        }

        for (let i = 0; i < plants.length; i += 1) {
            const plant = plants[i];
            const delay = i * 0.018;

            plant.group.scale.setScalar(band(progress, 0.04 + delay, 0.38 + delay));
            plant.group.rotation.z = Math.sin(elapsed * 0.3 + plant.phase) * 0.015;

            for (let l = 0; l < plant.leaves.length; l += 1) {
                const leaf = plant.leaves[l];
                leaf.scale.setScalar(band(progress, 0.24 + delay + l * 0.035, 0.52 + delay + l * 0.035));
                leaf.rotation.x = Math.sin(elapsed * 0.65 + leaf.userData.phase) * 0.05;
            }

            plant.ear.scale.setScalar(band(progress, 0.7, 0.93));
            plant.ear.rotation.x = Math.sin(elapsed * 0.45 + i) * 0.03;
        }

        camera.position.y = 3.3 + easeOut(progress) * 1.0;
        camera.position.z = 11.0 - easeOut(Math.min(progress * 1.5, 1)) * 2.4;
        camera.lookAt(0, 2.1 + progress * 0.75, 0);

        renderer.render(scene, camera);
    }

    const clock = new THREE.Clock();

    lockPage();
    window.addEventListener('wheel', onWheel, { passive: false });
    window.addEventListener('keydown', onKeyDown, { passive: false });
    window.addEventListener('touchstart', onTouchStart, { passive: false });
    window.addEventListener('touchmove', onTouchMove, { passive: false });
    window.addEventListener('touchend', onTouchEnd, { passive: false });
    window.addEventListener('scroll', onScroll, { passive: true });
    window.addEventListener('resize', resize, { passive: true });

    resize();
    animate();
})();
