import { component, signal } from '/js/vendor/reef.es.min.js';
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
        this._id = null;
        this.uuid = crypto.randomUUID();
        this.signal = signal({
            title: null,
            cards: []
        }, this.uuid);
        component(
            this,
            this.template.bind(this),
            {
                signals: [this.uuid],
            }
        )
    }

    // connectedCallback() {
    //     console.log("ColumnElement : Connected " + this._id);
    // }

    attributeChangedCallback(name, oldValue, newValue) {
        if (name === "id") {
            this._id = newValue;
        }
    }

    setTitle(title) {
        // console.log('ColumnElement: setTitle(' + title + ')');
        this.signal.title = title;
    }

    template () {
        // console.log("ColumnElement : render " + this._id);
        let { title, cards } = this.signal;
        return `
        <div class="column" id="col${this._id}">
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
