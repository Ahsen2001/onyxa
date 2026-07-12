import './bootstrap';

const initRichTextEditors = async () => {
    const textareas = [...document.querySelectorAll('textarea[data-ckeditor]')];

    if (textareas.length === 0) {
        return;
    }

    const { default: ClassicEditor } = await import('@ckeditor/ckeditor5-build-classic');

    textareas.forEach((textarea) => {
        if (textarea.dataset.ckeditorReady === 'true') {
            return;
        }

        textarea.dataset.ckeditorReady = 'true';

        ClassicEditor
            .create(textarea, {
                ckfinder: {
                    uploadUrl: textarea.dataset.uploadUrl,
                },
                toolbar: [
                    'heading',
                    '|',
                    'bold',
                    'italic',
                    'link',
                    'bulletedList',
                    'numberedList',
                    'blockQuote',
                    '|',
                    'insertTable',
                    'imageUpload',
                    'undo',
                    'redo',
                ],
                image: {
                    toolbar: ['imageTextAlternative', 'imageStyle:inline', 'imageStyle:block', 'imageStyle:side'],
                },
            })
            .catch((error) => {
                console.error('CKEditor initialization failed:', error);
                textarea.dataset.ckeditorReady = 'false';
            });
    });
};

const initMediaPickers = () => {
    document.querySelectorAll('[data-media-picker]').forEach((picker) => {
        const id = picker.dataset.mediaPicker;
        const modal = document.querySelector(`[data-media-modal="${id}"]`);
        const input = document.querySelector(`[data-media-input="${id}"]`);
        const preview = document.querySelector(`[data-media-preview="${id}"]`);
        const search = document.querySelector(`[data-media-search="${id}"]`);

        document.querySelector(`[data-media-open="${id}"]`)?.addEventListener('click', () => {
            modal?.classList.remove('hidden');
        });

        document.querySelector(`[data-media-close="${id}"]`)?.addEventListener('click', () => {
            modal?.classList.add('hidden');
        });

        modal?.addEventListener('click', (event) => {
            if (event.target === modal) {
                modal.classList.add('hidden');
            }
        });

        document.querySelector(`[data-media-clear="${id}"]`)?.addEventListener('click', () => {
            if (input) {
                input.value = '';
            }

            if (preview) {
                preview.src = '';
                preview.classList.add('hidden');
            }
        });

        document.querySelectorAll(`[data-media-option="${id}"]`).forEach((option) => {
            option.addEventListener('click', () => {
                if (input) {
                    input.value = option.dataset.mediaId || '';
                }

                if (preview && option.dataset.mediaUrl) {
                    preview.src = option.dataset.mediaUrl;
                    preview.classList.remove('hidden');
                }

                modal?.classList.add('hidden');
            });
        });

        search?.addEventListener('input', () => {
            const query = search.value.trim().toLowerCase();

            document.querySelectorAll(`[data-media-option="${id}"]`).forEach((option) => {
                const keywords = option.dataset.mediaKeywords || '';
                option.classList.toggle('hidden', query !== '' && ! keywords.includes(query));
            });
        });
    });
};

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', () => {
        initMediaPickers();
        initRichTextEditors();
    });
} else {
    initMediaPickers();
    initRichTextEditors();
}
