import CustomElement from '/js/util/custom-element.js';
import { component, signal } from '/js/vendor/reef.es.min.js';

class ColumnElement extends CustomElement
{
    constructor () {
        super();
        this.uuid = crypto.randomUUID();
        this.signal = signal({
            title: null
        }, this.uuid);
        this.cardListWatcher = null;
        component(
            this,
            this.template.bind(this),
            {
                signals: [this.uuid],
            }
        )
    }

    setup() {
        super.setup();

        this.listen(this, 'reef:render', (e) => {
            // Emit a colin:column-card-list event when the column changes
            this.observe(
                this.querySelector('.card-list'),
                'colin:column-card-list'
            );
            // Listen for column changes and hide or show the delete button
            this.listen(this, 'colin:column-card-list', (e) => {
                const btn = this.querySelector('.control__remove')
                if (btn) {
                    btn.style.display = (0 === e.detail.observed.children.length) ? 'block' : 'none';
                }
            });
        });

        this.listen(this, 'click', (e) => {
            e.preventDefault();
            this.emit('colin:column-remove', {
                column: this,
            });
        }, '.control__remove');
    }

    setTitle(title) {
        this.signal.title = title;
    }

    template () {
        let { title } = this.signal;
        return `
        <div class="column" id="col${this.id()}">
            <div class="column__header">
                <h2 class="handle">
                    ${title}
                </h2>
                <div class="column__control">
                    <button class="control__remove">X</button>
                </div>
            </div>
            <div class="column__content card-list"></div>
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
