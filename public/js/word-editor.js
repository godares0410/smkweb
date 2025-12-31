/**
 * Word Editor - Custom WYSIWYG Editor
 * Editor seperti MS Word dengan icon dan fungsi lengkap
 */

(function() {
    'use strict';

    class WordEditor {
        constructor(selector, options = {}) {
            this.selector = selector;
            this.element = document.querySelector(selector);
            if (!this.element) {
                console.error('Element tidak ditemukan:', selector);
                return;
            }

            this.options = {
                height: options.height || 500,
                placeholder: options.placeholder || 'Tulis konten di sini...',
                ...options
            };

            this.init();
        }

        init() {
            // Create editor container
            this.createEditor();
            // Setup toolbar
            this.setupToolbar();
            // Setup iframe content
            this.setupContent();
            // Bind events
            this.bindEvents();
        }

        createEditor() {
            // Hide original textarea
            this.element.style.display = 'none';

            // Create editor wrapper
            this.wrapper = document.createElement('div');
            this.wrapper.className = 'word-editor-wrapper';
            this.wrapper.style.cssText = `
                border: 1px solid #ddd;
                border-radius: 4px;
                background: #fff;
                margin-bottom: 1rem;
            `;

            // Create toolbar
            this.toolbar = document.createElement('div');
            this.toolbar.className = 'word-editor-toolbar';
            this.toolbar.style.cssText = `
                background: #f8f9fa;
                border-bottom: 1px solid #ddd;
                padding: 8px;
                display: flex;
                flex-wrap: wrap;
                gap: 4px;
                border-radius: 4px 4px 0 0;
            `;

            // Create editor area
            this.editorArea = document.createElement('div');
            this.editorArea.className = 'word-editor-area';
            this.editorArea.contentEditable = true;
            this.editorArea.style.cssText = `
                min-height: ${this.options.height}px;
                padding: 15px;
                outline: none;
                font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
                font-size: 14px;
                line-height: 1.6;
                color: #333;
                overflow-y: auto;
            `;

            // Set initial content
            this.editorArea.innerHTML = this.element.value || '';

            // Append to wrapper
            this.wrapper.appendChild(this.toolbar);
            this.wrapper.appendChild(this.editorArea);

            // Insert after textarea
            this.element.parentNode.insertBefore(this.wrapper, this.element.nextSibling);
        }

        setupToolbar() {
            const buttons = [
                // Format Group
                { icon: 'bi-type-bold', title: 'Bold (Ctrl+B)', command: 'bold', group: 'format' },
                { icon: 'bi-type-italic', title: 'Italic (Ctrl+I)', command: 'italic', group: 'format' },
                { icon: 'bi-type-underline', title: 'Underline (Ctrl+U)', command: 'underline', group: 'format' },
                { icon: 'bi-type-strikethrough', title: 'Strikethrough', command: 'strikeThrough', group: 'format' },
                { separator: true },
                
                // Font Size
                { icon: 'bi-fonts', title: 'Font Size', type: 'select', options: [
                    { value: '1', text: '8pt' },
                    { value: '2', text: '10pt' },
                    { value: '3', text: '12pt' },
                    { value: '4', text: '14pt' },
                    { value: '5', text: '18pt' },
                    { value: '6', text: '24pt' },
                    { value: '7', text: '36pt' }
                ], command: 'fontSize', group: 'format' },
                { separator: true },

                // Alignment
                { icon: 'bi-text-left', title: 'Align Left', command: 'justifyLeft', group: 'align' },
                { icon: 'bi-text-center', title: 'Align Center', command: 'justifyCenter', group: 'align' },
                { icon: 'bi-text-right', title: 'Align Right', command: 'justifyRight', group: 'align' },
                { icon: 'bi-justify', title: 'Justify', command: 'justifyFull', group: 'align' },
                { separator: true },

                // Lists
                { icon: 'bi-list-ul', title: 'Bullet List', command: 'insertUnorderedList', group: 'list' },
                { icon: 'bi-list-ol', title: 'Numbered List', command: 'insertOrderedList', group: 'list' },
                { separator: true },

                // Indent
                { icon: 'bi-text-indent-left', title: 'Decrease Indent', command: 'outdent', group: 'indent' },
                { icon: 'bi-text-indent-right', title: 'Increase Indent', command: 'indent', group: 'indent' },
                { separator: true },

                // Colors
                { icon: 'bi-type', title: 'Text Color', type: 'color', command: 'foreColor', group: 'color' },
                { icon: 'bi-highlighter', title: 'Background Color', type: 'color', command: 'backColor', group: 'color' },
                { separator: true },

                // Links & Media
                { icon: 'bi-link-45deg', title: 'Insert Link', command: 'createLink', group: 'insert' },
                { icon: 'bi-image', title: 'Insert Image', command: 'insertImage', group: 'insert' },
                { separator: true },

                // Table
                { icon: 'bi-table', title: 'Insert Table', command: 'insertTable', group: 'table' },
                { separator: true },

                // Undo/Redo
                { icon: 'bi-arrow-counterclockwise', title: 'Undo (Ctrl+Z)', command: 'undo', group: 'edit' },
                { icon: 'bi-arrow-clockwise', title: 'Redo (Ctrl+Y)', command: 'redo', group: 'edit' },
                { separator: true },

                // Clear Format
                { icon: 'bi-eraser', title: 'Clear Formatting', command: 'removeFormat', group: 'format' },
                { separator: true },

                // View
                { icon: 'bi-code-slash', title: 'View Source', command: 'viewSource', group: 'view' },
            ];

            buttons.forEach(btn => {
                if (btn.separator) {
                    const separator = document.createElement('div');
                    separator.className = 'word-editor-separator';
                    separator.style.cssText = 'width: 1px; background: #ddd; margin: 0 4px;';
                    this.toolbar.appendChild(separator);
                    return;
                }

                const button = document.createElement('button');
                button.type = 'button';
                button.className = 'word-editor-btn';
                button.title = btn.title;
                button.style.cssText = `
                    background: transparent;
                    border: 1px solid transparent;
                    padding: 6px 10px;
                    cursor: pointer;
                    border-radius: 3px;
                    display: inline-flex;
                    align-items: center;
                    justify-content: center;
                    color: #495057;
                    font-size: 16px;
                    transition: all 0.2s;
                `;

                if (btn.type === 'select') {
                    // Create select dropdown
                    const select = document.createElement('select');
                    select.className = 'word-editor-select';
                    select.style.cssText = `
                        padding: 4px 8px;
                        border: 1px solid #ddd;
                        border-radius: 3px;
                        background: #fff;
                        cursor: pointer;
                    `;
                    select.innerHTML = '<option value="">Font Size</option>';
                    btn.options.forEach(opt => {
                        const option = document.createElement('option');
                        option.value = opt.value;
                        option.textContent = opt.text;
                        select.appendChild(option);
                    });
                    select.addEventListener('change', (e) => {
                        document.execCommand(btn.command, false, e.target.value);
                        this.editorArea.focus();
                    });
                    button.appendChild(select);
                } else if (btn.type === 'color') {
                    // Create color picker button with visual indicator
                    const colorIndicator = document.createElement('span');
                    colorIndicator.className = 'color-indicator';
                    const defaultColor = btn.command === 'foreColor' ? '#000000' : '#ffffff';
                    colorIndicator.style.cssText = `
                        position: absolute;
                        bottom: 2px;
                        left: 2px;
                        right: 2px;
                        height: 3px;
                        background: ${defaultColor};
                        border-radius: 2px;
                        pointer-events: none;
                        z-index: 1;
                    `;
                    
                    button.innerHTML = `<i class="bi ${btn.icon}"></i>`;
                    button.appendChild(colorIndicator);
                    button.setAttribute('data-command', btn.command);
                    button.style.position = 'relative';
                    button.style.overflow = 'visible';
                    
                    // Store reference
                    const self = this;
                    const command = btn.command;
                    
                    // Color change handler
                    const handleColorChange = (color) => {
                        // Update color indicator
                        colorIndicator.style.background = color;
                        
                        // Ensure editor is focused
                        self.editorArea.focus();
                        
                        // Check if there's a selection in editor
                        const selection = window.getSelection();
                        let hasSelection = false;
                        let range = null;
                        
                        if (selection.rangeCount > 0) {
                            range = selection.getRangeAt(0);
                            hasSelection = !range.collapsed && 
                                         self.editorArea.contains(range.commonAncestorContainer);
                        }
                        
                        if (!hasSelection) {
                            // If no selection, select all text in editor
                            range = document.createRange();
                            range.selectNodeContents(self.editorArea);
                            selection.removeAllRanges();
                            selection.addRange(range);
                        }
                        
                        // Apply color command
                        try {
                            let success = document.execCommand(command, false, color);
                            
                            if (!success) {
                                // Fallback: wrap selection in span with inline style
                                const sel = window.getSelection();
                                if (sel.rangeCount > 0) {
                                    const rng = sel.getRangeAt(0);
                                    if (!rng.collapsed) {
                                        const span = document.createElement('span');
                                        if (command === 'foreColor') {
                                            span.style.color = color;
                                        } else if (command === 'backColor') {
                                            span.style.backgroundColor = color;
                                        }
                                        
                                        try {
                                            rng.surroundContents(span);
                                        } catch (e) {
                                            const contents = rng.extractContents();
                                            span.appendChild(contents);
                                            rng.insertNode(span);
                                        }
                                        
                                        sel.removeAllRanges();
                                        success = true;
                                    }
                                }
                            }
                            
                            if (!success) {
                                console.warn('Color command failed, color will apply to next typed text');
                            }
                        } catch (err) {
                            console.error('Error applying color:', err);
                        }
                        
                        // Keep focus on editor
                        self.editorArea.focus();
                        self.updateToolbar();
                    };
                    
                    // Create color picker popup
                    // Check if ColorPicker class is available
                    if (typeof ColorPicker !== 'undefined') {
                        const colorPicker = new ColorPicker(button, command, defaultColor, handleColorChange);
                    } else {
                        // Fallback: use native color input with label
                        const colorInputId = 'color-input-' + btn.command + '-' + Math.random().toString(36).substr(2, 9);
                        const colorInput = document.createElement('input');
                        colorInput.type = 'color';
                        colorInput.id = colorInputId;
                        colorInput.value = defaultColor;
                        colorInput.style.cssText = `
                            position: absolute;
                            top: 0;
                            left: 0;
                            width: 100%;
                            height: 100%;
                            opacity: 0;
                            cursor: pointer;
                            z-index: 30;
                            margin: 0;
                            padding: 0;
                            border: none;
                            font-size: 0;
                        `;
                        
                        const colorLabel = document.createElement('label');
                        colorLabel.setAttribute('for', colorInputId);
                        colorLabel.style.cssText = `
                            position: absolute;
                            top: 0;
                            left: 0;
                            width: 100%;
                            height: 100%;
                            cursor: pointer;
                            z-index: 25;
                            margin: 0;
                            padding: 0;
                        `;
                        
                        colorInput.addEventListener('change', function(e) {
                            handleColorChange(this.value);
                        });
                        
                        button.addEventListener('click', function(e) {
                            e.preventDefault();
                            e.stopPropagation();
                            self.editorArea.focus();
                            colorLabel.click();
                        });
                        
                        button.appendChild(colorInput);
                        button.appendChild(colorLabel);
                    }
                } else {
                    button.innerHTML = `<i class="bi ${btn.icon}"></i>`;
                    button.setAttribute('data-command', btn.command);
                    button.addEventListener('click', (e) => {
                        e.preventDefault();
                        if (btn.command === 'createLink') {
                            this.insertLink();
                        } else if (btn.command === 'insertImage') {
                            this.insertImage();
                        } else if (btn.command === 'insertTable') {
                            this.insertTable();
                        } else if (btn.command === 'viewSource') {
                            this.toggleSource();
                        } else {
                            document.execCommand(btn.command, false, null);
                            this.editorArea.focus();
                        }
                        this.updateToolbar();
                    });
                }

                // Hover effect
                button.addEventListener('mouseenter', () => {
                    button.style.background = '#e9ecef';
                    button.style.borderColor = '#dee2e6';
                });
                button.addEventListener('mouseleave', () => {
                    if (!button.classList.contains('active')) {
                        button.style.background = 'transparent';
                        button.style.borderColor = 'transparent';
                    }
                });

                this.toolbar.appendChild(button);
            });
        }

        setupContent() {
            // Set placeholder
            if (!this.editorArea.textContent.trim()) {
                this.editorArea.setAttribute('data-placeholder', this.options.placeholder);
                this.editorArea.classList.add('placeholder');
            }

            // Handle placeholder
            this.editorArea.addEventListener('focus', () => {
                if (this.editorArea.classList.contains('placeholder')) {
                    this.editorArea.textContent = '';
                    this.editorArea.classList.remove('placeholder');
                }
            });

            this.editorArea.addEventListener('blur', () => {
                if (!this.editorArea.textContent.trim()) {
                    this.editorArea.setAttribute('data-placeholder', this.options.placeholder);
                    this.editorArea.classList.add('placeholder');
                }
            });

            // Sync with textarea
            this.editorArea.addEventListener('input', () => {
                this.syncToTextarea();
            });

            // Keyboard shortcuts
            this.editorArea.addEventListener('keydown', (e) => {
                // Ctrl+B for bold
                if (e.ctrlKey && e.key === 'b') {
                    e.preventDefault();
                    document.execCommand('bold', false, null);
                }
                // Ctrl+I for italic
                if (e.ctrlKey && e.key === 'i') {
                    e.preventDefault();
                    document.execCommand('italic', false, null);
                }
                // Ctrl+U for underline
                if (e.ctrlKey && e.key === 'u') {
                    e.preventDefault();
                    document.execCommand('underline', false, null);
                }
                // Ctrl+Z for undo
                if (e.ctrlKey && e.key === 'z' && !e.shiftKey) {
                    e.preventDefault();
                    document.execCommand('undo', false, null);
                }
                // Ctrl+Y or Ctrl+Shift+Z for redo
                if ((e.ctrlKey && e.key === 'y') || (e.ctrlKey && e.shiftKey && e.key === 'z')) {
                    e.preventDefault();
                    document.execCommand('redo', false, null);
                }
            });

            // Update toolbar on selection change
            this.editorArea.addEventListener('mouseup', () => this.updateToolbar());
            this.editorArea.addEventListener('keyup', () => this.updateToolbar());
        }

        bindEvents() {
            // Update toolbar buttons state
            this.updateToolbar();
        }

        updateToolbar() {
            const buttons = this.toolbar.querySelectorAll('.word-editor-btn');
            buttons.forEach(btn => {
                const command = btn.getAttribute('data-command');
                if (command && command !== 'createLink' && command !== 'insertImage' && 
                    command !== 'insertTable' && command !== 'viewSource') {
                    try {
                        const isActive = document.queryCommandState(command);
                        if (isActive) {
                            btn.classList.add('active');
                            btn.style.background = '#dee2e6';
                            btn.style.borderColor = '#adb5bd';
                        } else {
                            btn.classList.remove('active');
                            btn.style.background = 'transparent';
                            btn.style.borderColor = 'transparent';
                        }
                    } catch (e) {
                        // Ignore errors for commands that don't support queryCommandState
                    }
                }
            });
        }

        insertLink() {
            const url = prompt('Masukkan URL:', 'http://');
            if (url) {
                document.execCommand('createLink', false, url);
                this.editorArea.focus();
            }
        }

        insertImage() {
            const url = prompt('Masukkan URL gambar:', '');
            if (url) {
                document.execCommand('insertImage', false, url);
                this.editorArea.focus();
            }
        }

        insertTable() {
            const rows = prompt('Jumlah baris:', '3');
            const cols = prompt('Jumlah kolom:', '3');
            if (rows && cols) {
                let table = '<table border="1" style="border-collapse: collapse; width: 100%; margin: 10px 0;">';
                for (let i = 0; i < parseInt(rows); i++) {
                    table += '<tr>';
                    for (let j = 0; j < parseInt(cols); j++) {
                        table += '<td style="padding: 8px; border: 1px solid #ddd;">&nbsp;</td>';
                    }
                    table += '</tr>';
                }
                table += '</table>';
                document.execCommand('insertHTML', false, table);
                this.editorArea.focus();
            }
        }

        toggleSource() {
            if (this.editorArea.style.display === 'none') {
                // Show editor
                this.editorArea.style.display = 'block';
                this.sourceArea.style.display = 'none';
            } else {
                // Show source
                if (!this.sourceArea) {
                    this.sourceArea = document.createElement('textarea');
                    this.sourceArea.className = 'word-editor-source';
                    this.sourceArea.style.cssText = `
                        width: 100%;
                        min-height: ${this.options.height}px;
                        padding: 15px;
                        border: none;
                        font-family: 'Courier New', monospace;
                        font-size: 12px;
                        background: #f8f9fa;
                    `;
                    this.wrapper.appendChild(this.sourceArea);
                }
                this.sourceArea.value = this.editorArea.innerHTML;
                this.editorArea.style.display = 'none';
                this.sourceArea.style.display = 'block';
                this.sourceArea.focus();

                // Update on change
                this.sourceArea.addEventListener('blur', () => {
                    this.editorArea.innerHTML = this.sourceArea.value;
                    this.syncToTextarea();
                });
            }
        }

        syncToTextarea() {
            this.element.value = this.editorArea.innerHTML;
        }

        getContent() {
            return this.editorArea.innerHTML;
        }

        setContent(html) {
            this.editorArea.innerHTML = html;
            this.syncToTextarea();
        }
    }

    // Auto-initialize
    function initEditors() {
        document.querySelectorAll('textarea[id="content"]').forEach(textarea => {
            if (!textarea.closest('.word-editor-wrapper')) {
                new WordEditor('#' + textarea.id);
            }
        });
    }

    // Initialize on DOM ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initEditors);
    } else {
        initEditors();
    }

    // Export for manual initialization
    if (typeof window !== 'undefined') {
        window.WordEditor = WordEditor;
    }
})();

