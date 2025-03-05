import { Editor } from 'https://esm.sh/@tiptap/core@2.6.6';
import StarterKit from 'https://esm.sh/@tiptap/starter-kit@2.6.6';

window.addEventListener('DOMContentLoaded', function () {
    if (document.getElementById("wysiwyg-typography-example")) {

        // tip tap editor setup
        const editor = new Editor({
            element: document.querySelector('#wysiwyg-typography-example'),
            extensions: [
                StarterKit
            ],
            content: '<p>Flowbite is an <strong>open-source library of UI components</strong> based on the utility-first Tailwind CSS framework featuring dark mode support, a Figma design system, and more.</p><p>It includes all of the commonly used components that a website requires, such as buttons, dropdowns, navigation bars, modals, datepickers, advanced charts and the list goes on.</p><ul><li>Over 600+ open-source UI components</li><li>Supports dark mode and RTL</li><li>Available in React, Vue, Svelte frameworks</li></ul><p>Here is an example of a button component:</p><pre><code>&#x3C;button type=&#x22;button&#x22; class=&#x22;text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800&#x22;&#x3E;Default&#x3C;/button&#x3E;</code></pre><p>Learn more about all components from the <a href="https://flowbite.com/docs/getting-started/introduction/">Flowbite Docs</a>.</p>',
            editorProps: {
                attributes: {
                    class: 'format lg:format-lg dark:format-invert focus:outline-none format-blue max-w-none',
                },
            }
        });

        const editorContainers = this.document.querySelectorAll('.editor-container')

        editorContainers.forEach((container) => {
            // set up custom event listeners for the buttons
            container.querySelector('.toggleListButton')?.addEventListener('click', () => {
                editor.chain().focus().toggleBulletList().run();
            });
            container.querySelector('.toggleOrderedListButton')?.addEventListener('click', () => {
                editor.chain().focus().toggleOrderedList().run();
            });
            container.querySelector('.toggleBlockquoteButton')?.addEventListener('click', () => {
                editor.chain().focus().toggleBlockquote().run();
            });
            container.querySelector('.toggleHRButton')?.addEventListener('click', () => {
                editor.chain().focus().setHorizontalRule().run();
            });
            container.querySelector('.toggleCodeBlockButton')?.addEventListener('click', () => {
                editor.chain().focus().toggleCodeBlock().run();
            });

            // typography dropdown
            const typographyDropdown2 = FlowbiteInstances.getInstance('Dropdown', 'typographyDropdown321');

            container.querySelector('.toggleParagraphButton').addEventListener('click', () => {
                editor.chain().focus().setParagraph().run();
                typographyDropdown2.hide();
            });
            
            container.querySelectorAll('[data-heading-level]').forEach((button) => {
                button.addEventListener('click', () => {
                    const level = button.getAttribute('data-heading-level');
                    editor.chain().focus().toggleHeading({ level: parseInt(level) }).run()
                    typographyDropdown2.hide();
                });
            });
        });

    }
})
