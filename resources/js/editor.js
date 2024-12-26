import EditorJS from '@editorjs/editorjs'
import Header from '@editorjs/header';
import Quote from '@editorjs/quote';
import ImageTool from '@editorjs/image';

const editor = new EditorJS({
    holder: 'editorjs',

    tools: {

        header: {
            class: Header,
            config: {
                placeholder: 'Başlık yazın'
            }
        },
        quote: {
            class: Quote,
            inlineToolbar: true,
            shortcut: 'CMD+SHIFT+O',
            config: {
                quotePlaceholder: 'Enter a quote',
                captionPlaceholder: 'Quote\'s author',
            },
        },
        image: {
            class: ImageTool,
            config: {
                endpoints: {
                    byFile: "/editor/image/upload", // Laravel'deki upload metodu
                    byUrl: "/editor/image/fetch"    // Laravel'deki fetch metodu
                },
                additionalRequestHeaders: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
            }
        },
    },
});
