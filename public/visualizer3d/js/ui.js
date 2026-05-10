export class UISystem {
    constructor() {
        this.panel = document.getElementById('info-panel');
        this.title = document.getElementById('pTitle');
        this.soil = document.getElementById('pSoil');
        this.cultureList = document.getElementById('cultureList');
        
        this.createLocalReportUI();
        this.init();
    }

    init() {
        // Any specific startup UI logic
    }

    createLocalReportUI() {
        const report = document.createElement('div');
        report.id = 'local-report';
        report.style.cssText = `
            position: fixed;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            background: rgba(0,0,0,0.7);
            color: #fff;
            padding: 10px 30px;
            border-radius: 50px;
            font-weight: 800;
            font-size: 0.9rem;
            letter-spacing: 1px;
            text-transform: uppercase;
            border: 2px solid var(--accent);
            opacity: 0;
            transition: all 0.3s;
            z-index: 200;
            pointer-events: none;
            display: flex;
            align-items: center;
            gap: 15px;
        `;
        document.body.appendChild(report);
        this.localReport = report;
    }

    updatePanel(data) {
        this.title.textContent = data.nom;
        this.soil.textContent = 'Sol: ' + (data.typeSol || 'Normal');
        
        // Minimalist Culture List
        this.cultureList.innerHTML = '';
        data.cultures.forEach(c => {
            const div = document.createElement('div');
            div.className = 'c-item';
            div.style.padding = '8px';
            div.innerHTML = `
                <div class="c-name" style="font-size:0.7rem;">${c.nom} <span style="color:var(--accent); float:right;">${c.growth}%</span></div>
            `;
            this.cultureList.appendChild(div);
        });

        // Dynamic Legend
        const legend = document.querySelector('.legend');
        if (legend) {
            legend.innerHTML = '';
            data.cultures.forEach(c => {
                const color = this.getCultureColor(c.typeCulture);
                const item = document.createElement('div');
                item.className = 'l-item';
                item.innerHTML = `<div class="l-dot" style="background: #${color.toString(16).padStart(6, '0')}"></div> ${c.typeCulture}`;
                legend.appendChild(item);
            });
        }

        this.panel.classList.add('visible');
    }

    getCultureColor(type) {
        const t = type.toLowerCase();
        if (t.includes('blé')) return 0xd4af37;
        if (t.includes('maïs')) return 0xffff00;
        if (t.includes('tomate')) return 0xff0000;
        if (t.includes('banane')) return 0xfde047;
        if (t.includes('rose')) return 0xb91c1c;
        return 0x228b22;
    }

    showLocalReport(zone) {
        this.localReport.innerHTML = `
            <span style="font-size:1.2rem;">📍</span> 
            Secteur: <span style="color:var(--accent)">${zone.nom}</span> 
            • Surface: ${zone.surface} m² 
            • État: ${zone.etat}
        `;
        this.localReport.style.opacity = '1';
        this.localReport.style.top = '40px';
    }

    hideLocalReport() {
        this.localReport.style.opacity = '0';
        this.localReport.style.top = '20px';
    }
}
