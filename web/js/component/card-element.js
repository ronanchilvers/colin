import { component } from '/js/vendor/reef.es.min.js';
import { store } from '/js/util/store.js';

class CardElement extends HTMLElement
{
    static get observedAttributes() {
        return [
            'id',
        ];
    }

    constructor () {
        super();
        this.cardId = null;
        component(
            this,
            this.template.bind(this)
        )
    }

    attributeChangedCallback(name, oldValue, newValue) {
        if (name == "id") {
            this.cardId = newValue;
        }
    }

    template () {
        let card = store.cards[this.cardId];
        return `
        <div class="card">
            <div class="card__header">
                <h3>${card.title}</h3>
            </div>
        </div>
        `;
    }
}

customElements.define(
    'card-element',
    CardElement
);
