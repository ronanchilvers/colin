// Bind a proxy variable to the change event of a selector
function bind(proxy, selector, eventType = "input") {
    document.addEventListener(
        eventType,
        function (event) {
            if (!event.target.matches(selector)) return;
            proxy.value = event.target.value;
        }
    );
}

export { bind };
