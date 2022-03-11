const autoCompleteJS = new autoComplete({
    // placeHolder: 'Search for Food...',
    data: {
        src: async query => {
            try {
                // Fetch Data from external Source
                const apiUrl = autoCompleteJS.input.dataset.apiUrl;
                const source = await fetch(`${apiUrl}/${query}`);
                // Data is array of `Objects` | `Strings`
                const data = await source.json();
                console.log(source);
                return data;
            } catch (error) {
                return error;
            }
        },
        // Data 'Object' key to be searched
        keys: ['text']
    },
    resultItem: {
        highlight: true
    },
    events: {
        input: {
            selection: event => {
                const selection = event.detail.selection.value;
                autoCompleteJS.input.value = selection.text;

                document.querySelector('#latitude').value = selection.pos[1];
                document.querySelector('#longitude').value = selection.pos[0];
                // document.querySelector('#city_name').value = selection.city ? selection.city : 0;
            }
        }
    }
});

