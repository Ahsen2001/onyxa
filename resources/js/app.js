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

const initProductGalleries = () => {
    document.querySelectorAll('[data-product-gallery]').forEach((gallery) => {
        const mainImage = gallery.querySelector('[data-product-main-image]');
        const thumbs = [...gallery.querySelectorAll('[data-product-thumb]')];

        if (! mainImage || thumbs.length === 0) {
            return;
        }

        thumbs.forEach((thumb, index) => {
            if (index === 0) {
                thumb.classList.add('border-[#8B5E3C]');
            }

            thumb.addEventListener('click', () => {
                mainImage.src = thumb.dataset.full || mainImage.src;
                mainImage.alt = thumb.dataset.alt || mainImage.alt;

                thumbs.forEach((item) => item.classList.remove('border-[#8B5E3C]'));
                thumb.classList.add('border-[#8B5E3C]');
            });
        });
    });
};

const initProductNameDropdowns = () => {
    const categorySelect = document.querySelector('[data-product-category-select]');
    const nameSelect = document.querySelector('[data-product-name-select]');

    if (! categorySelect || ! nameSelect) {
        return;
    }

    let optionsByCategory = {};

    try {
        optionsByCategory = JSON.parse(nameSelect.dataset.productNameOptions || '{}');
    } catch (error) {
        console.error('Product name options could not be parsed:', error);
    }

    const renderNames = () => {
        const categoryId = categorySelect.value;
        const names = optionsByCategory[categoryId] || [];
        const currentName = nameSelect.dataset.currentProductName || '';
        const selectedValue = names.includes(nameSelect.value) ? nameSelect.value : currentName;

        nameSelect.innerHTML = '';

        const placeholder = document.createElement('option');
        placeholder.value = '';
        placeholder.textContent = categoryId ? 'Select product name' : 'Select product category first';
        nameSelect.appendChild(placeholder);

        if (selectedValue && ! names.includes(selectedValue)) {
            const currentOption = document.createElement('option');
            currentOption.value = selectedValue;
            currentOption.textContent = selectedValue;
            nameSelect.appendChild(currentOption);
        }

        names.forEach((name) => {
            const option = document.createElement('option');
            option.value = name;
            option.textContent = name;
            nameSelect.appendChild(option);
        });

        nameSelect.value = selectedValue && [...nameSelect.options].some((option) => option.value === selectedValue)
            ? selectedValue
            : '';
        nameSelect.disabled = categoryId === '' || nameSelect.options.length <= 1;
    };

    categorySelect.addEventListener('change', () => {
        nameSelect.value = '';
        nameSelect.dataset.currentProductName = '';
        renderNames();
    });

    renderNames();
};

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', () => {
        initMediaPickers();
        initRichTextEditors();
        initProductGalleries();
        initProductNameDropdowns();
    });
} else {
    initMediaPickers();
    initRichTextEditors();
    initProductGalleries();
    initProductNameDropdowns();
}
