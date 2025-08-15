import { signal, component } from '/js/vendor/reef.es.min.js';

class BoardHeader extends HTMLElement
{

    constructor () {
        super();
        component(
            this,
            this.template
        )
    }

    template () {
        let { title } = data;
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

let data = signal({
    title: "Board",
})
