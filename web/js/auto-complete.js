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

                document.getElementById('lat').value = selection.pos[1];
                document.getElementById('long').value = selection.pos[0];
                document.getElementById('city').value = selection.city ? selection.city : 0;
            }
        }
    }
});
