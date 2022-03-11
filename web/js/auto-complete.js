const autoCompleteJS = new autoComplete({
    data: {
        src: async query => {
            try {
                const apiUrl = autoCompleteJS.input.dataset.apiUrl;
                const source = await fetch(`${apiUrl}/${query}`);
                const data = await source.json();
                return data;
            } catch (error) {
                return error;
            }
        },
        keys: ['text']
    },
    resultItem: {
        highlight: true
    },
    events: {
        input: {
            selection: event => {
                const selectionValue = event.detail.selection.value;
                autoCompleteJS.input.value = selectionValue.text;
                document.querySelector('#latitude').value = selectionValue.pos[1];
                document.querySelector('#longitude').value = selectionValue.pos[0];
                document.querySelector('#city_name').value = selectionValue.city ? selectionValue.city : 0;
                document.querySelector('#address').value = selectionValue.text ? selectionValue.text : 0;
            }
        }
    }
});

