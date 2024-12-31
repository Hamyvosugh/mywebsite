<?php
/*
Template Name: Brand Guidelines
Template Post Type: page
*/

get_header(); ?>

<div class="brand-guidelines-container">
    <!-- Left Sidebar -->
    <div class="controls-sidebar">
        <!-- Save Button -->
        <div class="save-button-container">
            <button id="save-guidelines" class="elementor-button elementor-button-success">
                <i class="eicon-save"></i> Save Guidelines
            </button>
        </div>

        <!-- Controls Container -->
        <div class="controls-content">
            <!-- Menu Controls Section -->
            <div class="control-section">
                <h3 class="section-header">Menu Styles</h3>
                <div class="control-content">
                    <div class="color-group">
                        <label>Menu Text</label>
                        <div class="color-picker-wrapper">
                            <input type="color" id="menu-color" value="#333333" class="color-picker">
                            <span class="color-value">#333333</span>
                        </div>
                    </div>
                    <div class="color-group">
                        <label>Menu Hover</label>
                        <div class="color-picker-wrapper">
                            <input type="color" id="menu-hover-color" value="#007bff" class="color-picker">
                            <span class="color-value">#007bff</span>
                        </div>
                    </div>
                    <div class="color-group">
                        <label>Active Menu</label>
                        <div class="color-picker-wrapper">
                            <input type="color" id="menu-active-color" value="#0056b3" class="color-picker">
                            <span class="color-value">#0056b3</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Background Colors Section -->
            <div class="control-section">
                <h3 class="section-header">Background Colors</h3>
                <div class="control-content">
                    <div class="color-group">
                        <label>Main Background</label>
                        <div class="color-picker-wrapper">
                            <input type="color" id="background-color" value="#ffffff" class="color-picker">
                            <span class="color-value">#ffffff</span>
                        </div>
                    </div>
                    <div class="color-group">
                        <label>Text Block Background</label>
                        <div class="color-picker-wrapper">
                            <input type="color" id="block-color" value="#f8f9fa" class="color-picker">
                            <span class="color-value">#f8f9fa</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Text Controls Section -->
            <div class="control-section">
                <h3 class="section-header">Typography</h3>
                <div class="control-content">
                    <div class="font-group">
                        <label>Font Family</label>
                        <select id="font-family">
                            <option value="Arial, sans-serif">Arial</option>
                            <option value="Helvetica, sans-serif">Helvetica</option>
                            <option value="Georgia, serif">Georgia</option>
                            <option value="'Times New Roman', serif">Times New Roman</option>
                        </select>
                    </div>
                    <div class="font-group">
                        <label>Font Size</label>
                        <input type="number" id="font-size" value="16" min="12" max="32">
                        <span>px</span>
                    </div>
                    <div class="color-group">
                        <label>Text Color</label>
                        <div class="color-picker-wrapper">
                            <input type="color" id="text-color" value="#333333" class="color-picker">
                            <span class="color-value">#333333</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- CTA Button Controls -->
            <div class="control-section">
                <h3 class="section-header">CTA Button</h3>
                <div class="control-content">
                    <div class="color-group">
                        <label>Button Color</label>
                        <div class="color-picker-wrapper">
                            <input type="color" id="cta-color" value="#007bff" class="color-picker">
                            <span class="color-value">#007bff</span>
                        </div>
                    </div>
                    <div class="color-group">
                        <label>Button Hover</label>
                        <div class="color-picker-wrapper">
                            <input type="color" id="cta-hover-color" value="#0056b3" class="color-picker">
                            <span class="color-value">#0056b3</span>
                        </div>
                    </div>
                    <div class="color-group">
                        <label>Button Text</label>
                        <div class="color-picker-wrapper">
                            <input type="color" id="cta-text-color" value="#ffffff" class="color-picker">
                            <span class="color-value">#ffffff</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Navigation Dots Controls -->
            <div class="control-section">
                <h3 class="section-header">Navigation Dots</h3>
                <div class="control-content">
                    <div class="color-group">
                        <label>Dot Color</label>
                        <div class="color-picker-wrapper">
                            <input type="color" id="dot-color" value="#cccccc" class="color-picker">
                            <span class="color-value">#cccccc</span>
                        </div>
                    </div>
                    <div class="color-group">
                        <label>Active Dot</label>
                        <div class="color-picker-wrapper">
                            <input type="color" id="dot-active-color" value="#007bff" class="color-picker">
                            <span class="color-value">#007bff</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Logo Section Controls -->
            <div class="control-section">
                <h3 class="section-header">Logo Backgrounds</h3>
                <div class="control-content">
                    <div class="color-group">
                        <label>Light Background</label>
                        <div class="color-picker-wrapper">
                            <input type="color" id="logo-light-bg" value="#ffffff" class="color-picker">
                            <span class="color-value">#ffffff</span>
                        </div>
                    </div>
                    <div class="color-group">
                        <label>Dark Background</label>
                        <div class="color-picker-wrapper">
                            <input type="color" id="logo-dark-bg" value="#212529" class="color-picker">
                            <span class="color-value">#212529</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    
    
    <!-- Add this in the controls-sidebar section, after the existing sections -->

<div class="control-section">
    <h3 class="section-header">Logo Settings</h3>
    <div class="control-content">
        <!-- Light Logo Upload -->
        <div class="logo-upload-group">
            <label>Logo for Light Background</label>
            <div class="logo-preview" id="light-logo-preview">
                <img src="" alt="Light logo preview" style="display: none;">
                <span class="no-logo">No logo selected</span>
            </div>
            <button class="upload-btn" id="upload-light-logo">
                <i class="eicon-upload"></i> Select Logo
            </button>
            <button class="remove-btn" id="remove-light-logo" style="display: none;">
                <i class="eicon-trash"></i> Remove
            </button>
            <input type="hidden" id="light-logo-id">
        </div>

        <!-- Dark Logo Upload -->
        <div class="logo-upload-group">
            <label>Logo for Dark Background</label>
            <div class="logo-preview" id="dark-logo-preview">
                <img src="" alt="Dark logo preview" style="display: none;">
                <span class="no-logo">No logo selected</span>
            </div>
            <button class="upload-btn" id="upload-dark-logo">
                <i class="eicon-upload"></i> Select Logo
            </button>
            <button class="remove-btn" id="remove-dark-logo" style="display: none;">
                <input type="hidden" id="dark-logo-id">
            </button>
        </div>
    </div>
</div>

<style>
/* Logo Upload Styles */
.logo-upload-group {
    margin-bottom: 20px;
}

.logo-preview {
    width: 100%;
    height: 100px;
    border: 2px dashed #ddd;
    border-radius: 4px;
    margin: 10px 0;
    display: flex;
    align-items: center;
     
    background: #f8f9fa;
    overflow: hidden;
}

.logo-preview img {
    max-width: 100%;
    max-height: 100%;
    object-fit: contain;
}

.no-logo {
    color: #999;
    font-size: 13px;
}

.upload-btn, .remove-btn {
    padding: 8px 12px;
    border: 1px solid #ddd;
    border-radius: 4px;
    background: #fff;
    cursor: pointer;
    font-size: 13px;
    margin-right: 10px;
}

.upload-btn:hover {
    background: #f8f9fa;
}

.remove-btn {
    color: #dc3545;
    border-color: #dc3545;
}

.remove-btn:hover {
    background: #dc3545;
    color: #fff;
}
</style>

<script>
jQuery(document).ready(function($) {
    // Media Uploader for Logos
    function initMediaUploader(buttonId, previewId, logoIdInput) {
        let mediaUploader;
        
        $('#' + buttonId).click(function(e) {
            e.preventDefault();
            
            if (mediaUploader) {
                mediaUploader.open();
                return;
            }
            
            mediaUploader = wp.media({
                title: 'Select Logo',
                button: {
                    text: 'Use this logo'
                },
                multiple: false
            });
            
            mediaUploader.on('select', function() {
                const attachment = mediaUploader.state().get('selection').first().toJSON();
                $('#' + previewId + ' img').attr('src', attachment.url).show();
                $('#' + previewId + ' .no-logo').hide();
                $('#' + logoIdInput).val(attachment.id);
                $('#remove-' + buttonId.split('-')[1]).show();
            });
            
            mediaUploader.open();
        });
        
        // Remove logo
        $('#remove-' + buttonId.split('-')[1]).click(function() {
            $('#' + previewId + ' img').attr('src', '').hide();
            $('#' + previewId + ' .no-logo').show();
            $('#' + logoIdInput).val('');
            $(this).hide();
        });
    }
    
    // Initialize uploaders
    initMediaUploader('upload-light-logo', 'light-logo-preview', 'light-logo-id');
    initMediaUploader('upload-dark-logo', 'dark-logo-preview', 'dark-logo-id');
    
    // Update preview function
    function updatePreview() {
        // Menu updates
        $('.preview-menu a').css({
            'color': $('#menu-color').val()
        });
        $('.preview-menu li.active a').css({
            'color': $('#menu-active-color').val()
        });
        
        // Background updates
        $('#preview-section').css({
            'background-color': $('#background-color').val()
        });
        
        // Text block updates
        $('.text-block').css({
            'background-color': $('#block-color').val(),
            'color': $('#text-color').val(),
            'font-family': $('#font-family').val(),
            'font-size': $('#font-size').val() + 'px'
        });
        
        // CTA Button updates
        $('.cta-button').css({
            'background-color': $('#cta-color').val(),
            'color': $('#cta-text-color').val()
        });
        
        // Navigation dots updates
        $('.dot').css('background-color', $('#dot-color').val());
        $('.dot.active').css('background-color', $('#dot-active-color').val());
        
        // Logo section updates
        $('.logo-section.light').css('background-color', $('#logo-light-bg').val());
        $('.logo-section.dark').css('background-color', $('#logo-dark-bg').val());
        
        // Add hover effects
        let styleSheet = document.styleSheets[0];
        let hoverRules = [
            `.cta-button:hover { background-color: ${$('#cta-hover-color').val()} !important; }`,
            `.preview-menu a:hover { color: ${$('#menu-hover-color').val()} !important; }`
        ];
        
        // Remove existing hover rules if they exist
        for(let i = styleSheet.cssRules.length - 1; i >= 0; i--) {
            if(styleSheet.cssRules[i].selectorText && 
               (styleSheet.cssRules[i].selectorText.includes(':hover'))) {
                styleSheet.deleteRule(i);
            }
        }
        
        // Add new hover rules
        hoverRules.forEach(rule => {
            styleSheet.insertRule(rule, styleSheet.cssRules.length);
        });
    }
    
    // Update on any control change
    $('.color-picker, #font-family, #font-size').on('input change', function() {
        $(this).siblings('.color-value').text($(this).val());
        updatePreview();
    });
    
    // Initial preview update
    updatePreview();
});
</script>
    
    
    
    
    
    
    
    
    
    
    

    <!-- Preview Area -->
    <div class="preview-area">
        <div class="preview-container" id="preview-section">
            <!-- Preview Menu -->
            <nav class="preview-menu">
                <ul>
                    <li class="active"><a href="#">Home</a></li>
                    <li><a href="#">About</a></li>
                    <li><a href="#">Services</a></li>
                    <li><a href="#">Contact</a></li>
                </ul>
            </nav>

            <!-- Content Area -->
            <div class="hero-content">
                <div class="text-block">
                    <h2>Welcome to Our Website</h2>
                    <p>This is a sample text block to demonstrate how your selected colors work together. 
                       The background, text, and various elements will update as you adjust the colors.</p>
                    <button class="cta-button">Call to Action</button>
                </div>
            </div>

            <!-- Navigation Dots -->
            <div class="nav-dots">
                <span class="dot active"></span>
                <span class="dot"></span>
                <span class="dot"></span>
            </div>

            <!-- Logo Section -->
            <div class="logo-sections">
                <div class="logo-section light">
                    <div class="logo-placeholder">Logo on Light</div>
                </div>
                <div class="logo-section dark">
                    <div class="logo-placeholder">Logo on Dark</div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Main Container */
.brand-guidelines-container {
    display: flex;
    min-height: calc(100vh - 32px); /* Account for WP admin bar */
    margin: 0;
    padding: 0;
}

/* Sidebar Styles */
.controls-sidebar {
    width: 300px;
    background: #f8f9fa;
    border-right: 1px solid #ddd;
    height: 100vh;
    position: fixed;
    left: 0;
    top: 0;
    overflow: hidden;
    display: flex;
    flex-direction: column;
}

.save-button-container {
    padding: 15px;
    background: #fff;
    border-bottom: 1px solid #ddd;
    position: sticky;
    top: 0;
    z-index: 100;
}

.controls-content {
    padding: 20px;
    overflow-y: auto;
    flex: 1;
}

/* Control Sections */
.control-section {
    margin-bottom: 20px;
    background: #fff;
    border-radius: 6px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
}

.section-header {
    padding: 12px 15px;
    margin: 0;
    background: #f1f3f5;
    border-bottom: 1px solid #ddd;
    font-size: 14px;
    border-radius: 6px 6px 0 0;
}

.control-content {
    padding: 15px;
}

/* Color Picker Styles */
.color-group {
    margin-bottom: 15px;
}

.color-picker-wrapper {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-top: 5px;
}

.color-picker {
    width: 40px;
    height: 40px;
    padding: 0;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

.color-value {
    font-family: monospace;
    font-size: 12px;
}

/* Preview Area */
.preview-area {
    flex: 1;
    margin-left: 300px;
    padding: 30px;
    background: #e9ecef;
    min-height: 100vh;
}

.preview-container {
    background: #fff;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    padding: 30px;
    height: calc(100vh - 100px);
    display: flex;
    flex-direction: column;
}

/* Preview Elements */
.preview-menu {
    padding: 15px 0;
    border-bottom: 1px solid #eee;
}

.preview-menu ul {
    display: flex;
     
    list-style: none;
    margin: 0;
    padding: 0;
}

.preview-menu li {
    margin: 0 15px;
}

.preview-menu a {
    text-decoration: none;
    padding: 5px 10px;
}

.hero-content {
    flex: 1;
    display: flex;
    align-items: center;
     
    text-align: center;
    padding: 30px;
}

.text-block {
    max-width: 600px;
    padding: 30px;
    border-radius: 8px;
}

.text-block h2 {
    margin-bottom: 20px;
}

.cta-button {
    margin-top: 20px;
    padding: 12px 24px;
    border: none;
    border-radius: 4px;
    font-size: 16px;
    cursor: pointer;
    transition: all 0.3s ease;
}

.nav-dots {
    text-align: center;
    padding: 15px 0;
}

.dot {
    display: inline-block;
    width: 8px;
    height: 8px;
    border-radius: 50%;
    margin: 0 5px;
    cursor: pointer;
}

.logo-sections {
    display: flex;
    margin-top: 20px;
    border-radius: 8px;
    overflow: hidden;
}

.logo-section {
    flex: 1;
    height: 120px;
    display: flex;
    align-items: center;
     
}

.logo-placeholder {
    padding: 15px;
    font-size: 14px;
}

/* Form Controls */
select, input[type="number"] {
    width: 100%;
    padding: 8px;
    border: 1px solid #ddd;
    border-radius: 4px;
    margin-top: 5px;
}

label {
    display: block;
    margin-bottom: 5px;
    font-size: 13px;
    color: #666;
}
</style>

[Previous JavaScript remains the same...]

<?php get_footer(); ?>