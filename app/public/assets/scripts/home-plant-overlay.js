(function () {
    const overlay = document.getElementById('plant-intro-overlay');
    const canvas = document.getElementById('plant-intro-canvas');
    const body = document.body;
    const title = document.getElementById('plant-intro-title');
    const subtitle = document.getElementById('plant-intro-sub');
    const panelElements = [
        { element: document.getElementById('plant-panel-left-a'), phase: 0.4, side: -1 },
        { element: document.getElementById('plant-panel-left-b'), phase: 1.1, side: -1 },
        { element: document.getElementById('plant-panel-left-c'), phase: 1.8, side: -1 },
        { element: document.getElementById('plant-panel-right-a'), phase: 0.7, side: 1 },
        { element: document.getElementById('plant-panel-right-b'), phase: 1.45, side: 1 },
        { element: document.getElementById('plant-panel-right-c'), phase: 2.15, side: 1 },
    ].filter(function (item) { return !!item.element; });
    const panelStartBase = 0.34;
    const panelStep = 0.07;
    const panelWindow = 0.14;
    const panelConfigs = panelElements.map(function (item, index) {
        const start = panelStartBase + index * panelStep;
        return {
            element: item.element,
            start: start,
            end: Math.min(start + panelWindow, 0.83),
            phase: item.phase,
            side: item.side,
        };
    });
    const progressFill = document.getElementById('plant-intro-fill');
    const progressText = document.getElementById('plant-intro-text');
    const diveButton = document.getElementById('plant-intro-dive');

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

    function lerp(a, b, t) {
        return a + (b - a) * t;
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

    function updateDiveButtonVisibility() {
        if (!diveButton) {
            return;
        }

        if (progress >= 0.992) {
            diveButton.classList.add('is-visible');
        } else {
            diveButton.classList.remove('is-visible');
        }
    }

    function onWheel(event) {
        if (finished) {
            event.preventDefault();
            return;
        }

        event.preventDefault();
        increaseProgress(event.deltaY);
    }

    function onKeyDown(event) {
        if (finished) {
            event.preventDefault();
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
        body.classList.add('intro-reveal');
        overlay.classList.add('is-complete');
        detachLockEvents();
        unlockPage();

        // Start reveal shortly after overlay fade begins so content animation remains visible.
        window.requestAnimationFrame(function () {
            window.setTimeout(function () {
                body.classList.add('intro-content-in');
                body.classList.remove('intro-pending');
            }, 260);
        });

        window.setTimeout(function () {
            overlay.style.display = 'none';
        }, 900);

        window.setTimeout(function () {
            body.classList.remove('intro-reveal');
            body.classList.remove('intro-content-in');
            body.classList.remove('intro-page');
        }, 1400);
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
                        : progress >= 0.992
                            ? 'ready to enter'
                            : 'almost ready';
        }

        const logoFade = 1 - clamp((progress - 0.06) / 0.45);
        if (title) {
            title.style.opacity = String(logoFade);
            title.style.transform = 'translate(-50%, -50%) scale(' + (1 + (1 - logoFade) * 0.06) + ')';

            if (body.classList.contains('admin-mode')) {
                const beigeShift = clamp((progress - 0.22) / 0.46);
                const start = { r: 188, g: 176, b: 150 };
                const end = { r: 236, g: 222, b: 194 };
                const r = Math.round(start.r + (end.r - start.r) * beigeShift);
                const g = Math.round(start.g + (end.g - start.g) * beigeShift);
                const b = Math.round(start.b + (end.b - start.b) * beigeShift);
                title.style.color = 'rgb(' + r + ', ' + g + ', ' + b + ')';
            }
        }

        if (subtitle) {
            const subtitleReveal = band(progress, 0.08, 0.24);
            subtitle.style.opacity = String(subtitleReveal * logoFade * 0.9);
        }

        updateDiveButtonVisibility();

        if (!diveButton && progress >= 0.995) {
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

    const root = overlay;
    const renderer = new THREE.WebGLRenderer({ canvas: canvas, antialias: true, alpha: true });
    renderer.setPixelRatio(Math.min(window.devicePixelRatio || 1, 2));
    renderer.shadowMap.enabled = true;
    renderer.shadowMap.type = THREE.PCFSoftShadowMap;
    renderer.toneMapping = THREE.ACESFilmicToneMapping;
    renderer.toneMappingExposure = 1.18;
    renderer.outputEncoding = THREE.sRGBEncoding;
    renderer.setClearColor(0, 0);

    const scene = new THREE.Scene();
    const cam = new THREE.PerspectiveCamera(40, 1, 0.1, 80);
    cam.position.set(0, 3.8, 9.5);
    cam.lookAt(0, 2.6, 0);

    function resize() {
        const width = root.clientWidth;
        const height = root.clientHeight;
        renderer.setSize(width, height, false);
        cam.aspect = width / height;
        cam.updateProjectionMatrix();
    }

    resize();

    if (typeof ResizeObserver !== 'undefined') {
        new ResizeObserver(resize).observe(root);
    }

    scene.add(new THREE.HemisphereLight(0xb8d8f5, 0x4a3a08, 0.72));

    const sun = new THREE.DirectionalLight(0xfff8e0, 2.4);
    sun.position.set(9, 18, 9);
    sun.castShadow = true;
    sun.shadow.mapSize.width = 1024;
    sun.shadow.mapSize.height = 1024;
    sun.shadow.camera.near = 0.5;
    sun.shadow.camera.far = 45;
    sun.shadow.camera.left = -8;
    sun.shadow.camera.right = 8;
    sun.shadow.camera.top = 12;
    sun.shadow.camera.bottom = -4;
    sun.shadow.bias = -0.001;
    scene.add(sun);

    const fill = new THREE.DirectionalLight(0xc5e0ff, 0.52);
    fill.position.set(-7, 5, -5);
    scene.add(fill);

    const back = new THREE.PointLight(0x80ff60, 0.38, 20);
    back.position.set(0, 6, -7);
    scene.add(back);

    const warm = new THREE.PointLight(0xffd080, 0.28, 12);
    warm.position.set(3, 1, 4);
    scene.add(warm);

    function sm(color, rough, metal, extra) {
        return new THREE.MeshStandardMaterial({
            color: color,
            roughness: rough !== undefined ? rough : 0.7,
            metalness: metal !== undefined ? metal : 0,
            ...(extra || {}),
        });
    }

    const gndMat = sm(0x3a2108, 0.95, 0, { transparent: true, opacity: 0 });
    const gnd = new THREE.Mesh(new THREE.CylinderGeometry(4, 4.4, 0.24, 56), gndMat);
    gnd.position.y = -0.12;
    gnd.receiveShadow = true;
    scene.add(gnd);

    const soilTopMat = sm(0x4a2c0c, 0.9, 0, { transparent: true, opacity: 0 });
    const soilTop = new THREE.Mesh(new THREE.CylinderGeometry(3.9, 3.9, 0.02, 48), soilTopMat);
    soilTop.position.y = 0.01;
    soilTop.receiveShadow = true;
    scene.add(soilTop);

    const ringGeo = new THREE.TorusGeometry(0.7, 0.07, 8, 32);
    const ringMat = sm(0x3e2208, 0.88, 0, { transparent: true, opacity: 0 });
    const ring = new THREE.Mesh(ringGeo, ringMat);
    ring.rotation.x = Math.PI / 2;
    ring.position.y = 0.02;
    scene.add(ring);

    const pebbleMats = [
        sm(0x8a7050, 0.9, 0, { transparent: true, opacity: 0 }),
        sm(0x7a6038, 0.88, 0, { transparent: true, opacity: 0 }),
        sm(0x6a5028, 0.92, 0, { transparent: true, opacity: 0 }),
        sm(0x9a8060, 0.85, 0, { transparent: true, opacity: 0 }),
    ];
    const pebbles = [];
    for (let i = 0; i < 22; i += 1) {
        const radius = 0.5 + Math.random() * 3;
        const angle = Math.random() * Math.PI * 2;
        const size = 0.04 + Math.random() * 0.09;
        const geo = new THREE.SphereGeometry(size, 7, 5);
        geo.scale(1 + Math.random() * 0.6, 0.3 + Math.random() * 0.5, 0.8 + Math.random() * 0.9);
        const pebble = new THREE.Mesh(geo, pebbleMats[i % 4]);
        pebble.position.set(Math.cos(angle) * radius, 0.01, Math.sin(angle) * radius);
        pebble.rotation.y = Math.random() * Math.PI * 2;
        pebble.receiveShadow = true;
        scene.add(pebble);
        pebbles.push(pebble);
    }

    function leafGeo(len, maxW, droop, twist, cup) {
        const ls = 32;
        const ws = 14;
        const pos = [];
        const col = [];
        const uv = [];
        const idx = [];
        const cMid = new THREE.Color(0x90d840);
        const cBlade = new THREE.Color(0x3e8c18);
        const cEdge = new THREE.Color(0x528a18);
        const cTip = new THREE.Color(0x7ab830);
        const cBase = new THREE.Color(0x2c6810);

        for (let i = 0; i <= ls; i += 1) {
            const t = i / ls;
            const wP = Math.pow(Math.sin(t * Math.PI * 0.94), 0.5) * (1 - 0.18 * t);
            const w = maxW * wP;
            const sagY = droop * t * t * len * 0.42;
            const sagZ = droop * t * len * 0.16;
            const bY = t * len - sagY;
            const ta = twist * t;

            for (let j = 0; j <= ws; j += 1) {
                const s = j / ws;
                const sc = s * 2 - 1;
                const vshape = cup * Math.abs(sc) * 0.8;
                const lx = sc * w;
                const ly = vshape;
                const rx = lx * Math.cos(ta) - ly * Math.sin(ta);
                const ry = lx * Math.sin(ta) + ly * Math.cos(ta);
                pos.push(rx, bY + ry, sagZ + sc * w * 0.018);

                const cd = Math.abs(sc);
                let c;
                if (cd < 0.12) {
                    c = cMid.clone().lerp(cBlade, cd / 0.12);
                } else if (cd > 0.82) {
                    c = cBlade.clone().lerp(cEdge, (cd - 0.82) / 0.18);
                } else {
                    c = cBlade.clone();
                }

                c.lerp(cTip, t * t * 0.38);
                c.lerp(cBase, (1 - t) * (1 - t) * 0.25);

                col.push(c.r, c.g, c.b);
                uv.push(s, t);
            }
        }

        for (let i = 0; i < ls; i += 1) {
            for (let j = 0; j < ws; j += 1) {
                const a = i * (ws + 1) + j;
                const b = a + 1;
                const c = (i + 1) * (ws + 1) + j;
                const d = c + 1;
                idx.push(a, c, b, b, c, d, b, c, a, d, c, b);
            }
        }

        const g = new THREE.BufferGeometry();
        g.setAttribute('position', new THREE.Float32BufferAttribute(pos, 3));
        g.setAttribute('color', new THREE.Float32BufferAttribute(col, 3));
        g.setAttribute('uv', new THREE.Float32BufferAttribute(uv, 2));
        g.setIndex(idx);
        g.computeVertexNormals();
        return g;
    }

    function mkLeaf(len, w, droop, twist, cup) {
        const mesh = new THREE.Mesh(
            leafGeo(len, w, droop, twist, cup),
            new THREE.MeshStandardMaterial({ vertexColors: true, side: THREE.DoubleSide, roughness: 0.5, metalness: 0 })
        );
        mesh.castShadow = true;
        return mesh;
    }

    function mkStem(height, lx, lz, r0, r1) {
        const pts = [
            new THREE.Vector3(0, 0, 0),
            new THREE.Vector3(lx * 0.12, height * 0.18, lz * 0.12),
            new THREE.Vector3(lx * 0.32, height * 0.38, lz * 0.3),
            new THREE.Vector3(lx * 0.55, height * 0.58, lz * 0.5),
            new THREE.Vector3(lx * 0.76, height * 0.76, lz * 0.7),
            new THREE.Vector3(lx * 0.9, height * 0.88, lz * 0.86),
            new THREE.Vector3(lx, height, lz),
        ];
        const curve = new THREE.CatmullRomCurve3(pts);
        const grp = new THREE.Group();
        const n = 7;
        const ps = curve.getPoints(n);
        const sM = sm(0x3c7c1c, 0.6);
        const nM = sm(0x2a6010, 0.68);

        for (let i = 0; i < n; i += 1) {
            const t = i / (n - 1);
            const rad = r0 * (1 - t) + r1 * t;
            const p1 = ps[i];
            const p2 = ps[i + 1];
            const dir = new THREE.Vector3().subVectors(p2, p1);
            const ln = dir.length();
            const mid = new THREE.Vector3().addVectors(p1, p2).multiplyScalar(0.5);
            const cyl = new THREE.Mesh(new THREE.CylinderGeometry(rad * 0.86, rad, ln * 1.06, 10), sM);
            cyl.position.copy(mid);
            const up = new THREE.Vector3(0, 1, 0);
            const dn = dir.clone().normalize();
            const ax = new THREE.Vector3().crossVectors(up, dn);
            if (ax.lengthSq() > 1e-6) {
                cyl.setRotationFromAxisAngle(ax.normalize(), Math.acos(Math.max(-1, Math.min(1, up.dot(dn)))));
            }
            cyl.castShadow = true;
            grp.add(cyl);

            if (i > 0) {
                const nd = new THREE.Mesh(new THREE.SphereGeometry(rad * 1.22, 9, 7), nM);
                nd.scale.y = 0.52;
                nd.position.copy(ps[i]);
                nd.castShadow = true;
                grp.add(nd);
            }
        }

        const veinM = sm(0x2a6012, 0.72);
        for (let v = 0; v < 4; v += 1) {
            const vA = v / 4 * Math.PI * 2;
            const vPts = ps.map(function (p) {
                return new THREE.Vector3(p.x + Math.cos(vA) * 0.04, p.y, p.z + Math.sin(vA) * 0.04);
            });
            const vCurve = new THREE.CatmullRomCurve3(vPts);
            const vGeo = new THREE.TubeGeometry(vCurve, 20, 0.006, 3, false);
            const vMesh = new THREE.Mesh(vGeo, veinM);
            vMesh.castShadow = false;
            grp.add(vMesh);
        }

        return { grp: grp, curve: curve };
    }

    function mkEar() {
        const g = new THREE.Group();
        const rLen = 1.0;
        const rPts = [
            new THREE.Vector3(0, 0, 0),
            new THREE.Vector3(0.01, rLen * 0.2, 0),
            new THREE.Vector3(0.03, rLen * 0.48, 0.012),
            new THREE.Vector3(0.07, rLen * 0.74, 0.05),
            new THREE.Vector3(0.14, rLen, 0.13),
        ];
        const rC = new THREE.CatmullRomCurve3(rPts);

        g.add(new THREE.Mesh(new THREE.TubeGeometry(rC, 24, 0.014, 8, false), sm(0xaa8818, 0.58)));

        const grM = sm(0xd0ac20, 0.46, 0.07, { emissive: 0x201000, emissiveIntensity: 0.2 });
        const glM = sm(0xa08012, 0.64);
        const awnM = sm(0xb87a08, 0.52);

        for (let i = 0; i < 16; i += 1) {
            const t = i / 15;
            const side = i % 2 === 0 ? 1 : -1;
            const rp = rC.getPoint(t * 0.88 + 0.04);
            const sp = new THREE.Group();
            sp.position.copy(rp);
            sp.rotation.z = side * 0.54;
            sp.rotation.x = 0.2 + t * 0.08;

            const gG = new THREE.SphereGeometry(1, 9, 9);
            gG.scale(0.05, 0.135, 0.036);
            const gl = new THREE.Mesh(gG, glM);
            gl.position.x = side * 0.05;
            gl.rotation.z = side * 0.28;
            sp.add(gl);

            for (let k = 0; k < 3; k += 1) {
                const grG = new THREE.SphereGeometry(1, 8, 8);
                grG.scale(0.038, 0.09, 0.032);
                const gr = new THREE.Mesh(grG, grM);
                gr.position.set(side * (0.062 + k * 0.013), k * 0.058, 0.008 + k * 0.004);
                gr.rotation.z = side * (0.3 + k * 0.05);
                gr.castShadow = true;
                sp.add(gr);

                const aL = 0.28 + Math.random() * 0.15;
                const aP = [
                    new THREE.Vector3(0, 0, 0),
                    new THREE.Vector3(side * 0.009, aL * 0.38, 0.004),
                    new THREE.Vector3(side * 0.02, aL * 0.72, 0.011),
                    new THREE.Vector3(side * 0.03, aL, 0.019),
                ];
                const aw = new THREE.Mesh(new THREE.TubeGeometry(new THREE.CatmullRomCurve3(aP), 9, 0.0032, 3, false), awnM);
                aw.position.set(side * 0.062, k * 0.058 + 0.09, 0.008);
                sp.add(aw);
            }

            g.add(sp);
        }

        return g;
    }

    const plantRoot = new THREE.Group();
    scene.add(plantRoot);

    function buildPlant(x, z, hs, lx, lz, ph) {
        const pg = new THREE.Group();
        pg.position.set(x, 0.18, z);

        const h = 3.9 * hs;
        const stemData = mkStem(h, lx, lz, 0.046, 0.019);
        pg.add(stemData.grp);

        const tp = [0.13, 0.26, 0.4, 0.54, 0.67, 0.8];
        const sz = [1.4, 1.62, 1.52, 1.3, 1.1, 0.84];
        const leafGrps = [];

        tp.forEach(function (leafPoint, li) {
            const lA = ph + li * 2.399;
            const lp = stemData.curve.getPoint(leafPoint);
            const lt = stemData.curve.getTangent(leafPoint).normalize();
            const lLen = sz[li] * (0.52 + hs * 0.48);
            const lW = lLen * (0.094 + Math.random() * 0.018);
            const lD = 0.28 + Math.random() * 0.28;
            const lT = 0.08 + Math.random() * 0.14;
            const leaf = mkLeaf(lLen, lW, lD, lT, 0.034);

            const sheathH = lLen * 0.2;
            const sheath = new THREE.Mesh(new THREE.CylinderGeometry(0.056, 0.05, sheathH, 10, 1, true), sm(0x2c680e, 0.72));
            sheath.position.y = sheathH * 0.5;
            sheath.castShadow = true;

            const ligule = new THREE.Mesh(new THREE.TorusGeometry(0.055, 0.006, 5, 12, Math.PI), sm(0x3a7818, 0.65));
            ligule.rotation.x = Math.PI / 2;
            ligule.position.y = sheathH;

            const lg = new THREE.Group();
            lg.add(sheath);
            lg.add(ligule);

            const blade = new THREE.Group();
            blade.add(leaf);
            blade.position.y = sheathH;
            blade.rotation.z = 0.08;
            lg.add(blade);

            lg.position.copy(lp);
            lg.rotation.y = lA;

            const up = new THREE.Vector3(0, 1, 0);
            const ax = new THREE.Vector3().crossVectors(up, lt);
            if (ax.lengthSq() > 1e-5) {
                lg.rotateOnWorldAxis(ax.normalize(), Math.acos(Math.max(-1, Math.min(1, up.dot(lt)))) * 0.44);
            }

            lg.scale.setScalar(0);
            lg.userData = { bA: lA, ph: Math.random() * Math.PI * 2 };
            pg.add(lg);
            leafGrps.push(lg);
        });

        const fl = mkLeaf(0.95, 0.112, 0.6, 0.22, 0.038);
        const flg = new THREE.Group();
        flg.add(fl);
        flg.position.copy(stemData.curve.getPoint(0.9));
        flg.rotation.y = ph + 0.85;
        flg.scale.setScalar(0);
        flg.userData = { bA: ph + 0.85, ph: 0.4 };
        pg.add(flg);
        leafGrps.push(flg);

        const pedPts = [stemData.curve.getPoint(0.9), stemData.curve.getPoint(0.96), stemData.curve.getPoint(1)];
        const pedCurve = new THREE.CatmullRomCurve3(pedPts);
        const pedMesh = new THREE.Mesh(new THREE.TubeGeometry(pedCurve, 8, 0.016, 7, false), sm(0x5a9820, 0.55));
        pedMesh.castShadow = true;
        pg.add(pedMesh);

        const ear = mkEar();
        ear.position.copy(stemData.curve.getPoint(1));
        ear.rotation.y = ph;
        ear.scale.setScalar(0);
        pg.add(ear);

        pg.scale.setScalar(0);
        plantRoot.add(pg);

        return { pg: pg, leafGrps: leafGrps, ear: ear };
    }

    const plantSeeds = [
        { x: 0, z: 0, hs: 1, lx: 0.05, lz: 0.02, ph: 0 },
        { x: -0.57, z: 0.22, hs: 0.89, lx: -0.04, lz: 0.06, ph: 1.22 },
        { x: 0.61, z: 0.17, hs: 0.92, lx: 0.06, lz: -0.04, ph: 2.44 },
        { x: -0.31, z: -0.51, hs: 0.83, lx: -0.03, lz: -0.05, ph: 3.66 },
        { x: 0.37, z: -0.47, hs: 0.86, lx: 0.04, lz: -0.03, ph: 4.88 },
    ];

    const plants = plantSeeds.map(function (seed) {
        return buildPlant(seed.x, seed.z, seed.hs, seed.lx, seed.lz, seed.ph);
    });

    const grassBlades = [];
    const grassColors = [0x3a7818, 0x4a8820, 0x2e6610, 0x528e20, 0x3e7014, 0x44801a];
    for (let i = 0; i < 80; i += 1) {
        const radius = 0.5 + Math.random() * 3;
        const angle = Math.random() * Math.PI * 2;
        const h = 0.16 + Math.random() * 0.52;
        const lean = (Math.random() - 0.5) * 0.2;
        const gPts = [
            new THREE.Vector3(0, 0, 0),
            new THREE.Vector3(lean * 0.4, h * 0.45, 0.002),
            new THREE.Vector3(lean, h, 0),
        ];
        const blade = new THREE.Mesh(new THREE.TubeGeometry(new THREE.CatmullRomCurve3(gPts), 6, 0.01 + Math.random() * 0.01, 3, false), sm(grassColors[i % 6], 0.78));
        blade.position.set(Math.cos(angle) * radius, 0.18, Math.sin(angle) * radius);
        blade.rotation.y = Math.random() * Math.PI * 2;
        blade.scale.setScalar(0);
        blade.userData = { ph: Math.random() * Math.PI * 2, ws: 0.35 + Math.random() * 0.65 };
        scene.add(blade);
        grassBlades.push(blade);
    }

    const particles = [];
    const particleColors = [0x5a9814, 0xd4a520, 0x1596d6, 0x7fbb2e, 0x44b6e6, 0xffec80];
    for (let i = 0; i < 36; i += 1) {
        const p = new THREE.Mesh(new THREE.SphereGeometry(0.012 + Math.random() * 0.018, 5, 5), sm(particleColors[i % 6], 0.45));
        const radius = 0.9 + Math.random() * 3;
        const angle = Math.random() * Math.PI * 2;
        p.position.set(Math.cos(angle) * radius, 0.4 + Math.random() * 3.8, Math.sin(angle) * radius);
        p.userData = { by: p.position.y, ph: Math.random() * Math.PI * 2, sp: 0.3 + Math.random() * 0.5 };
        p.scale.setScalar(0);
        scene.add(p);
        particles.push(p);
    }

    const clock = new THREE.Clock();

    function animate() {
        requestAnimationFrame(animate);

        const t = clock.getElapsedTime();
        const wx = Math.sin(t * 0.65) * 0.016 + Math.sin(t * 1.35) * 0.009;
        const wz = Math.cos(t * 0.82) * 0.012;

        updateOverlayUi();
        updatePanelMotion(t);

        grassBlades.forEach(function (blade) {
            blade.scale.setScalar(band(progress, 0, 0.14));
            blade.rotation.x = Math.sin(t * blade.userData.ws + blade.userData.ph) * 0.13 + wx;
            blade.rotation.z = Math.cos(t * blade.userData.ws * 0.7 + blade.userData.ph) * 0.06 + wz * 0.5;
        });

        plants.forEach(function (plant, pi) {
            const delay = pi * 0.055;
            plant.pg.scale.setScalar(band(progress, 0.04 + delay, 0.36 + delay));
            plant.leafGrps.forEach(function (lg, li) {
                lg.scale.setScalar(band(progress, 0.25 + delay + li * 0.038, 0.46 + delay + li * 0.038));
                lg.rotation.z = Math.sin(t * 0.72 + lg.userData.ph) * 0.038 + wx * 1.5;
                lg.rotation.x = Math.sin(t * 0.55 + lg.userData.ph + 1) * 0.015;
            });
            plant.ear.scale.setScalar(band(progress, 0.72, 0.92));
            plant.ear.rotation.x = Math.sin(t * 0.42 + pi) * 0.03 + wx * 0.45;
            plant.ear.rotation.z = Math.cos(t * 0.38 + pi) * 0.02 + wz * 0.3;
        });

        particles.forEach(function (p) {
            p.scale.setScalar(band(progress, 0.44, 0.7) * 2.2);
            p.position.y = p.userData.by + Math.sin(t * p.userData.sp + p.userData.ph) * 0.24;
            p.rotation.y += 0.008;
        });

        const groundReveal = band(progress, 0.02, 0.2);
        gndMat.opacity = groundReveal;
        soilTopMat.opacity = band(progress, 0.04, 0.24);
        ringMat.opacity = band(progress, 0.05, 0.26);
        pebbleMats.forEach(function (mat) {
            mat.opacity = band(progress, 0.03, 0.24);
        });
        gnd.position.y = -0.14 + groundReveal * 0.02;
        soilTop.position.y = 0.01 + band(progress, 0.04, 0.24) * 0.01;
        ring.position.y = 0.02 + band(progress, 0.05, 0.26) * 0.006;

        plantRoot.rotation.y = progress * Math.PI * 2.5 + Math.sin(t * 0.18) * 0.028;
        cam.position.y = lerp(3.8, 5.5, easeOut(progress));
        cam.position.z = lerp(9.5, 6, easeOut(clamp(progress * 1.6)));
        cam.lookAt(0, lerp(2.6, 3.8, progress), 0);

        renderer.render(scene, cam);
    }

    lockPage();

    if (diveButton) {
        diveButton.addEventListener('click', function () {
            completeIntro();
        });
    }

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
