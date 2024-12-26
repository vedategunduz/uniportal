import EditorJS from '@editorjs/editorjs'
import Header from '@editorjs/header';
import ImageTool from '@editorjs/image';
import EditorjsList from '@editorjs/list';
import ColorPicker from 'editorjs-color-picker';
import Delimiter from '@editorjs/delimiter';
import AttachesTool from '@editorjs/attaches';
import Table from '@editorjs/table'
import Marker from '@editorjs/marker';
import InlineCode from '@editorjs/inline-code';
import Underline from '@editorjs/underline';
import TextSpolier from 'editorjs-inline-spoiler-tool';
import ChangeCase from 'editorjs-change-case';
import Strikethrough from '@sotaproject/strikethrough';
import IndentTune from 'editorjs-indent-tune'
import DragDrop from "editorjs-drag-drop";
import Paragraph from '@editorjs/paragraph';
import AlignmentTune from 'editor-js-alignment-tune';
// import CodeTool from '@editorjs/code';
// import Quote from '@editorjs/quote';
// import LinkTool from '@editorjs/link';


const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

const editor = new EditorJS({
    holder: 'editorjs',

    onReady: () => {
        new DragDrop(editor);
    },

    tunes: ['indentTune'],

    i18n: {
        messages: {
            ui: {
                blockTunes: {
                    toggler: {
                        "Click to tune": "Ayarlamak için tıklayın",
                        'or drag to move': "veya taşımak için sürükleyin",
                    }
                },
                inlineToolbar: {
                    marker: {
                        "Marker": "İşaretci",
                    }
                },
                toolbar: {
                    toolbox: {
                        "Add": "Ekle",
                    }
                }
            },
            toolNames: {
                "Text": "Metin",
                "Heading": "Başlık",
                "Image": "Resim",
                "Attachment": "Dosya",
                "Unordered List": "Sırasız Liste",
                "Ordered List": "Sıralı Liste",
                "Delimiter": "Sınır",
                "Table": "Tablo",
                "Bold": "Kalın",
                "Color": "Renk",
                "Marker": "İşaretci",
                "Underline": "Altı Çizili",
                "Strikethrough": "Üstü Çizili",
                "InlineCode": "Kod",
                "ChangeCase": "Büyük/Küçük Harf değiştir",
                "Checklist": "Kontrol Listesi",
            },
            blockTunes: {
                delete: {
                    "Delete": "Kaldır",
                },
                "moveUp": {
                    "Move up": "Yukarı taşı"
                },
                "moveDown": {
                    "Move down": "Aşağı taşı"
                }
            }
        }
    },

    tools: {
        paragraph: {
            class: Paragraph,
            config: {
                placeholder: 'Metin...',
            },
            tunes: ['alignmentTune']
        },
        alignmentTune: {
            class: AlignmentTune,
            config: {
                default: 'left'
            }
        },
        header: {
            class: Header,
            config: {
                placeholder: 'Başlık',
                levels: [2, 3, 4, 5, 6],
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
        list: {
            class: EditorjsList,
            inlineToolbar: true,
        },
        ColorPicker: {
            class: ColorPicker,
        },
        delimiter: Delimiter,
        table: Table,
        underline: Underline,
        indentTune: IndentTune,
        strikethrough: Strikethrough,
        TextSpolier: TextSpolier,
        marker: {
            class: Marker,
        },
        inlineCode: {
            class: InlineCode,
        },
        changeCase: {
            class: ChangeCase,
        },
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
