import EditorJS from '@editorjs/editorjs'
import Header from '@editorjs/header';
import ImageTool from '@editorjs/image';
import EditorjsList from '@editorjs/list';
import Warning from '@editorjs/warning';
import ColorPicker from 'editorjs-color-picker';
import Delimiter from '@editorjs/delimiter';
import AttachesTool from '@editorjs/attaches';
import Table from '@editorjs/table'
import CodeTool from '@editorjs/code';
import Marker from '@editorjs/marker';
import InlineCode from '@editorjs/inline-code';
import Underline from '@editorjs/underline';
import TextSpolier from 'editorjs-inline-spoiler-tool';
import ChangeCase from 'editorjs-change-case';
// import Quote from '@editorjs/quote';
// import LinkTool from '@editorjs/link';

const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

const editor = new EditorJS({
    holder: 'editorjs',

    tools: {
        header: {
            class: Header,
            config: {
                placeholder: 'Başlık',
                levels: [2, 3, 4],
            }
        },
        image: {
            class: ImageTool,
            config: {
                additionalRequestHeaders: {
                    'X-CSRF-TOKEN': csrfToken
                },
                endpoints: {
                    byFile: "/editor/image/upload", // Laravel'deki upload metodu
                    byUrl: "/editor/image/fetch"    // Laravel'deki fetch metodu
                },
            }
        },
        list: {
            class: EditorjsList,
            inlineToolbar: true,
        },
        ColorPicker: {
            class: ColorPicker,
        },
        delimiter: Delimiter,
        code: CodeTool,
        table: Table,
        underline: Underline,
        TextSpolier: TextSpolier,
        warning: {
            class: Warning,
            inlineToolbar: true,
            shortcut: 'CMD+SHIFT+W',
            config: {
                titlePlaceholder: 'Başlık',
                messagePlaceholder: 'Mesaj',
            },
        },
        attaches: {
            class: AttachesTool,
            config: {
                additionalRequestHeaders: {
                    'X-CSRF-TOKEN': csrfToken
                },
                endpoint: '/editor/file/upload',
                buttonText: 'Dosya seç',
            }
        },
        marker: {
            class: Marker,
        },
        inlineCode: {
            class: InlineCode,
        },
        changeCase: {
            class: ChangeCase,
            config: {
                showLocaleOption: true, // enable locale case options
                locale: ['tr', 'TR', 'tr-TR']
            }
        }
    },
});

document.getElementById('saveEditor').addEventListener('click', () => {
    editor.save().then((outputData) => {
        console.log("Editor.js JSON verisi:", outputData);

        // Bu veriyi fetch ile /editor/store (POST) isteğine gönderiyoruz
        fetch('/editor/store', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify({
                icerik: outputData
            })
        })
            .then(response => response.json())
            .then(data => {
                console.log("Sunucudan gelen yanıt:", data);
                alert("Veri başarıyla kaydedildi!");
            })
            .catch(error => {
                console.error("Kaydederken hata oluştu:", error);
            });
    });
});
