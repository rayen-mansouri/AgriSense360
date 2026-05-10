export class UISystem {
    constructor() {
        this.panel = document.getElementById('info-panel');
        this.title = document.getElementById('pTitle');
        this.soil = document.getElementById('pSoil');
        this.cultureList = document.getElementById('cultureList');
        this.chart = null;
        this.init();
    }

    init() {
        // We'll use a simple CSS bar for growth chart to avoid heavy Chart.js if needed,
        // but since Chart.js is in index.html, we use it.
    }

    updatePanel(data) {
        this.title.textContent = data.nom;
        this.soil.textContent = 'Sol ' + data.typeSol;
        
        this.cultureList.innerHTML = '';
        data.cultures.forEach(c => {
            const div = document.createElement('div');
            div.className = 'c-item';
            div.innerHTML = `
                <div class="c-icon">${this.getIcon(c.typeCulture)}</div>
                <div class="c-info">
                    <div class="c-name">${c.nom}</div>
                    <div class="c-status">${c.etat} • ${c.surface} m²</div>
                    <div class="c-progress"><div class="c-bar" style="width: ${c.growth}%"></div></div>
                </div>
            `;
            this.cultureList.appendChild(div);
        });

        this.panel.classList.add('visible');
    }

    getIcon(name) {
        const n = name.toLowerCase();
        if (n.includes('blé')) return '🌾';
        if (n.includes('maïs')) return '🌽';
        if (n.includes('tomate')) return '🍅';
        if (n.includes('rose')) return '🌹';
        if (n.includes('tulipe')) return '🌷';
        if (n.includes('banane')) return '🍌';
        return '🌱';
    }
}
