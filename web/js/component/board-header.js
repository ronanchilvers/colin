import { signal, component } from '/js/vendor/reef.es.min.js';

class BoardHeader extends HTMLElement
{
    static get observedAttributes() {
        // console.log('BoardHeader: observedAttributes');
        return [
            'title',
        ];
    }

    constructor () {
        // console.log('BoardHeader: constructor');
        super();
        this.signal = signal({
            title: null,
        }, 'board-header');
        component(
            this,
            this.template.bind(this)
        );
    }

    attributeChangedCallback(name, oldValue, newValue) {
        if (name === "title") {
            // console.log('BoardHeader: attributeChangedCallback', name, oldValue, newValue);
            this.signal = { title: newValue };
        }
    }

    template () {
        let { title } = this.signal;
        // console.log('BoardHeader: template', title);
        return `
            <header>
                <h1>${title}</h1>
            </header>
        `;
    }

}

customElements.define(
    'board-header',
    BoardHeader
);
