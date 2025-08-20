import { component } from '/js/vendor/reef.es.min.js';
import { store } from '/js/util/store.js';

class ColumnElement extends HTMLElement
{
    static get observedAttributes() {
        return [
            'id',
        ];
    }

    constructor () {
        super();
        this.columnId = null;
        component(
            this,
            this.template.bind(this)
        )
    }

    connectedCallback() {
        console.log("Connected " + this.columnId);
    }

    attributeChangedCallback(name, oldValue, newValue) {
        if (name == "id") {
            this.columnId = newValue;
        }
    }

    template () {
        console.log("render " + this.columnId);
        let { title, cards } = store.columns.find(col => col.id === this.columnId);
        return `
        <div class="column">
            <div class="column__header">
                <h2 class="handle">
                    ${title}
                </h2>
                <div class="column__control">
                </div>
            </div>
            <div class="column__content card-list">
                ${cards.map(id => `<card-element id="${id}"></card-element>`).join('')}
            </div>
            <div class="add-card">
                <div>
                <input
                    placeholder="Add a card..."
                    autocomplete="off" />
                </div>
            </div>
        </div>
        `;
    }
}

customElements.define(
    'column-element',
    ColumnElement
);
