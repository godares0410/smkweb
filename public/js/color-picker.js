/**
 * Custom Color Picker
 * Popup color picker yang muncul saat icon color diklik
 */

(function() {
    'use strict';

    class ColorPicker {
        constructor(button, command, defaultColor, onColorChange) {
            this.button = button;
            this.command = command;
            this.defaultColor = defaultColor;
            this.onColorChange = onColorChange;
            this.isOpen = false;
            this.init();
        }

        init() {
            // Create popup container
            this.popup = document.createElement('div');
            this.popup.className = 'color-picker-popup';
            this.popup.style.cssText = `
                position: absolute;
                background: white;
                border: 1px solid #ddd;
                border-radius: 4px;
                padding: 15px;
                box-shadow: 0 4px 12px rgba(0,0,0,0.15);
                z-index: 10000;
                display: none;
                min-width: 250px;
            `;

            // Create color input
            this.colorInput = document.createElement('input');
            this.colorInput.type = 'color';
            this.colorInput.value = this.defaultColor;
            this.colorInput.style.cssText = `
                width: 100%;
                height: 50px;
                border: 1px solid #ddd;
                border-radius: 4px;
                cursor: pointer;
                margin-bottom: 10px;
            `;

            // Create preset colors
            const presetColors = [
                '#000000', '#333333', '#666666', '#999999', '#CCCCCC', '#FFFFFF',
                '#FF0000', '#FF6600', '#FFCC00', '#33FF00', '#00CCFF', '#0066FF',
                '#6600FF', '#FF00FF', '#FF0066', '#FF3366', '#FF6699', '#FF99CC'
            ];

            const presetContainer = document.createElement('div');
            presetContainer.style.cssText = 'display: grid; grid-template-columns: repeat(6, 1fr); gap: 5px;';
            
            presetColors.forEach(color => {
                const colorBtn = document.createElement('button');
                colorBtn.type = 'button';
                colorBtn.style.cssText = `
                    width: 30px;
                    height: 30px;
                    background: ${color};
                    border: 1px solid #ddd;
                    border-radius: 3px;
                    cursor: pointer;
                    padding: 0;
                `;
                colorBtn.title = color;
                colorBtn.addEventListener('click', () => {
                    this.selectColor(color);
                });
                presetContainer.appendChild(colorBtn);
            });

            // Create close button
            const closeBtn = document.createElement('button');
            closeBtn.type = 'button';
            closeBtn.innerHTML = 'Tutup';
            closeBtn.className = 'btn btn-sm btn-secondary mt-2 w-100';
            closeBtn.addEventListener('click', () => {
                this.close();
            });

            // Create label for preset colors
            const presetLabel = document.createElement('div');
            presetLabel.textContent = 'Atau pilih warna preset:';
            presetLabel.style.cssText = 'margin: 10px 0 5px 0; font-size: 12px; color: #666;';

            // Assemble popup
            this.popup.appendChild(this.colorInput);
            this.popup.appendChild(presetLabel);
            this.popup.appendChild(presetContainer);
            this.popup.appendChild(closeBtn);

            // Handle color input change
            this.colorInput.addEventListener('change', (e) => {
                this.selectColor(e.target.value);
            });

            // Append to body
            document.body.appendChild(this.popup);

            // Handle button click
            this.button.addEventListener('click', (e) => {
                e.preventDefault();
                e.stopPropagation();
                
                if (this.isOpen) {
                    this.close();
                } else {
                    this.open();
                }
            });

            // Close when clicking outside
            document.addEventListener('click', (e) => {
                if (this.isOpen && 
                    !this.popup.contains(e.target) && 
                    !this.button.contains(e.target)) {
                    this.close();
                }
            });
        }

        open() {
            this.isOpen = true;
            this.popup.style.display = 'block';
            
            // Position popup below button
            const rect = this.button.getBoundingClientRect();
            this.popup.style.top = (rect.bottom + 5) + 'px';
            this.popup.style.left = rect.left + 'px';
        }

        close() {
            this.isOpen = false;
            this.popup.style.display = 'none';
        }

        selectColor(color) {
            this.colorInput.value = color;
            if (this.onColorChange) {
                this.onColorChange(color);
            }
            this.close();
        }
    }

    // Export
    if (typeof window !== 'undefined') {
        window.ColorPicker = ColorPicker;
    }
})();

