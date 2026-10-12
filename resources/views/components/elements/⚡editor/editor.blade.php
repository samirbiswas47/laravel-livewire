
<div class="p-6">

    <form wire:submit="save">

        {{-- Description --}}
        <div class="mb-6">

            <label class="block font-bold mb-2">
                Description
            </label>

            <div wire:ignore>

                <textarea
                    class="editor"
                    data-model="description"
                >{{ $description }}</textarea>

            </div>

        </div>


        {{-- Notes --}}
        <div class="mb-6">

            <label class="block font-bold mb-2">
                Notes
            </label>

            <div wire:ignore>

                <textarea
                    class="editor"
                    data-model="notes"
                >{{ $notes }}</textarea>

            </div>

        </div>


        {{-- Save --}}
        <button
            type="submit"
            class="px-5 py-2 bg-purple-700 text-white rounded hover:bg-purple-800"
        >
            Save
        </button>

    </form>


    {{-- SunEditor initialization --}}
    @script
    <script>

        document
            .querySelectorAll('.editor')
            .forEach(function (element) {

                /*
                 * Prevent duplicate initialization
                 */
                if (element.dataset.initialized) {
                    return;
                }

                element.dataset.initialized = 'true';


                /*
                 * Create SunEditor
                 */
                const editor = SUNEDITOR.create(element, {

                    width: '100%',

                    height: '300px',

                    buttonList: [

                        ['undo', 'redo'],

                        '|',

                        [
                            'bold',
                            'italic',
                            'underline',
                            'strike'
                        ],

                        '|',

                        [
                            'fontSize',
                            'formatBlock'
                        ],

                        '|',

                        [
                            'fontColor',
                            'hiliteColor'
                        ],

                        '|',

                        [
                            'align',
                            'list'
                        ],

                        '|',

                        [
                            'link',
                            'image'
                        ],

                        '|',

                        [
                            'removeFormat'
                        ]

                    ]

                });


                /*
                 * Get Livewire property
                 */
                const model = element.dataset.model;


                /*
                 * Send SunEditor content to Livewire
                 */
                editor.onChange = function (contents) {

                    $wire.set(
                        model,
                        contents
                    );

                };

            });

    </script>
    @endscript

</div>
