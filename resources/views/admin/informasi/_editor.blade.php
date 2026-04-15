{{-- ══════════════════════════════════════════════════════════════════════ --}}
{{-- WYSIWYG Rich Text Editor Partial                                    --}}
{{-- Usage: @include('admin.informasi._editor', ['informasi' => $info])  --}}
{{-- ══════════════════════════════════════════════════════════════════════ --}}

<style>
/* ── Editor Toolbar ── */
.editor-toolbar {
  display: flex;
  align-items: center;
  gap: 1px;
  padding: 6px 8px;
  background: var(--bg);
  border: 1px solid var(--border);
  border-radius: 10px 10px 0 0;
  border-bottom: none;
  flex-wrap: wrap;
  position: sticky;
  top: 48px;
  z-index: 30;
}

.tb-group {
  display: flex;
  align-items: center;
  gap: 1px;
  padding: 0 3px;
}
.tb-group + .tb-group { border-left: 1px solid var(--border); }

.tb-btn {
  width: 32px; height: 32px;
  display: flex; align-items: center; justify-content: center;
  border-radius: 6px; border: none; background: none;
  color: var(--text-secondary); cursor: pointer;
  font-family: inherit; font-size: 13px; font-weight: 700;
  transition: all .15s; position: relative;
}
.tb-btn:hover { background: var(--surface); color: var(--text-primary); }
.tb-btn.active { background: var(--green-light); color: var(--green); }
.tb-btn .material-symbols-rounded { font-size: 18px; }
.tb-btn[title]:hover::after {
  content: attr(title);
  position: absolute; bottom: -28px; left: 50%; transform: translateX(-50%);
  background: var(--text-primary); color: #fff; font-size: 10px; font-weight: 600;
  padding: 3px 8px; border-radius: 5px; white-space: nowrap; z-index: 50;
  pointer-events: none;
}

/* ── Dropdown ── */
.tb-dropdown {
  position: relative;
}
.tb-dropdown-menu {
  display: none; position: absolute; top: 100%; left: 0; margin-top: 4px;
  background: var(--surface); border: 1px solid var(--border); border-radius: 8px;
  box-shadow: var(--shadow-md); z-index: 50; min-width: 140px; padding: 4px;
  max-height: 260px; overflow-y: auto;
}
.tb-dropdown-menu.show { display: block; }
.tb-dropdown-item {
  display: flex; align-items: center; gap: 8px;
  padding: 6px 10px; border-radius: 6px; border: none; background: none; width: 100%;
  color: var(--text-secondary); cursor: pointer; font-family: inherit; font-size: 12px;
  font-weight: 500; transition: background .1s; text-align: left;
}
.tb-dropdown-item:hover { background: var(--bg); color: var(--text-primary); }
.tb-dropdown-item .preview { font-weight: 700; }

/* ── Color Picker Grid ── */
.color-grid {
  display: grid; grid-template-columns: repeat(8, 1fr); gap: 3px; padding: 6px;
  min-width: 200px;
}
.color-swatch {
  width: 22px; height: 22px; border-radius: 4px; border: 2px solid transparent;
  cursor: pointer; transition: transform .1s, border-color .1s;
}
.color-swatch:hover { transform: scale(1.15); border-color: var(--text-primary); }

/* ── Content Area ── */
.editor-content {
  min-height: 320px; padding: 20px 22px;
  border: 1px solid var(--border); border-radius: 0 0 10px 10px;
  background: var(--surface); font-size: 14px; font-family: inherit;
  color: var(--text-primary); outline: none; line-height: 1.8;
  overflow-y: auto; word-wrap: break-word; overflow-wrap: break-word;
}
.editor-content:focus { border-color: var(--green); box-shadow: 0 0 0 3px rgba(22,163,74,.08); }
.editor-content:empty::before {
  content: attr(data-placeholder); color: var(--text-muted); pointer-events: none;
}
.editor-content img {
  max-width: 100%; height: auto; border-radius: 8px;
  margin: 8px 0; cursor: pointer; transition: outline .15s;
}
.editor-content img:hover { outline: 2px solid var(--green); outline-offset: 2px; }
.editor-content img.selected { outline: 3px solid var(--green); outline-offset: 2px; }
.editor-content blockquote {
  border-left: 4px solid var(--green-mid); margin: 12px 0; padding: 8px 16px;
  background: var(--green-light); border-radius: 0 8px 8px 0; color: var(--text-secondary);
}
.editor-content pre {
  background: #1e293b; color: #e2e8f0; padding: 14px 18px; border-radius: 8px;
  font-family: 'Fira Code', monospace; font-size: 12px; overflow-x: auto; margin: 8px 0;
}
.editor-content table { width: 100%; border-collapse: collapse; margin: 8px 0; }
.editor-content table td, .editor-content table th {
  border: 1px solid var(--border); padding: 8px 12px; font-size: 13px;
}
.editor-content table th { background: var(--bg); font-weight: 700; }
.editor-content hr { border: none; border-top: 2px solid var(--border); margin: 16px 0; }
.editor-content a { color: var(--green); text-decoration: underline; }

/* ── Image Resize Handle ── */
.img-resize-wrapper {
  display: inline-block; position: relative; line-height: 0;
}
.img-resize-handle {
  position: absolute; width: 10px; height: 10px; background: var(--green);
  border: 2px solid #fff; border-radius: 2px; cursor: nwse-resize; z-index: 10;
  box-shadow: 0 1px 3px rgba(0,0,0,.2);
}
.img-resize-handle.br { bottom: -5px; right: -5px; }

/* ── Image Modal ── */
.modal-overlay {
  display: none; position: fixed; inset: 0; background: rgba(0,0,0,.5);
  z-index: 100; align-items: center; justify-content: center;
  backdrop-filter: blur(4px);
}
.modal-overlay.show { display: flex; }
.modal-box {
  background: var(--surface); border-radius: 14px; box-shadow: 0 20px 60px rgba(0,0,0,.2);
  max-width: 480px; width: 90%; padding: 0; overflow: hidden;
}
.modal-header {
  padding: 16px 20px; border-bottom: 1px solid var(--border);
  display: flex; align-items: center; justify-content: space-between;
}
.modal-header h3 { font-size: 14px; font-weight: 700; display: flex; align-items: center; gap: 8px; }
.modal-header h3 .material-symbols-rounded { color: var(--green); }
.modal-close { background: none; border: none; cursor: pointer; color: var(--text-muted); padding: 4px; border-radius: 6px; }
.modal-close:hover { background: var(--bg); color: var(--text-primary); }
.modal-body { padding: 20px; display: flex; flex-direction: column; gap: 14px; }
.modal-footer { padding: 14px 20px; border-top: 1px solid var(--border); background: var(--bg); display: flex; justify-content: flex-end; gap: 8px; }

/* ── Upload Zone ── */
.upload-zone {
  border: 2px dashed var(--green-mid); background: var(--green-light); border-radius: 10px;
  padding: 24px; text-align: center; cursor: pointer; transition: all .2s;
}
.upload-zone:hover { border-color: var(--green); background: var(--green-light); }
.upload-zone.dragover { border-color: var(--green); background: var(--green-light); transform: scale(1.01); }
.upload-zone .material-symbols-rounded { font-size: 36px; color: var(--green); }
.upload-zone p { font-size: 12px; color: var(--text-secondary); margin-top: 6px; }
.upload-zone .hint { font-size: 10px; color: var(--text-muted); margin-top: 2px; }

.upload-progress { display: none; padding: 12px; background: var(--bg); border-radius: 8px; }
.upload-progress .bar-wrap { height: 6px; background: var(--border); border-radius: 3px; overflow: hidden; margin-top: 8px; }
.upload-progress .bar-fill { height: 100%; background: var(--green); border-radius: 3px; transition: width .3s; width: 0%; }

.url-input-wrap { display: flex; gap: 8px; }
.url-input-wrap input {
  flex: 1; padding: 8px 12px; border: 1px solid var(--border); border-radius: 8px;
  font-size: 13px; font-family: inherit; outline: none; background: var(--bg);
}
.url-input-wrap input:focus { border-color: var(--green); box-shadow: 0 0 0 3px rgba(22,163,74,.1); }

/* ── Emoji Picker ── */
.emoji-grid {
  display: grid; grid-template-columns: repeat(10, 1fr); gap: 2px; padding: 6px;
  max-height: 200px; overflow-y: auto; min-width: 280px;
}
.emoji-btn {
  width: 28px; height: 28px; display: flex; align-items: center; justify-content: center;
  border: none; background: none; cursor: pointer; border-radius: 4px;
  font-size: 16px; transition: background .1s;
}
.emoji-btn:hover { background: var(--bg); }

/* ── Link Modal ── */
.form-group-sm { display: flex; flex-direction: column; gap: 4px; }
.form-group-sm label {
  font-size: 10px; font-weight: 700; text-transform: uppercase;
  letter-spacing: .5px; color: var(--text-muted);
}
.form-group-sm input, .form-group-sm select {
  padding: 8px 12px; border: 1px solid var(--border); border-radius: 8px;
  font-size: 13px; font-family: inherit; outline: none; background: var(--bg);
}
.form-group-sm input:focus, .form-group-sm select:focus {
  border-color: var(--green); box-shadow: 0 0 0 3px rgba(22,163,74,.1);
}

/* ── Image Size Inputs ── */
.size-inputs { display: flex; align-items: center; gap: 8px; }
.size-inputs input {
  width: 80px; padding: 6px 10px; border: 1px solid var(--border); border-radius: 6px;
  font-size: 12px; font-family: inherit; outline: none; text-align: center;
}
.size-inputs input:focus { border-color: var(--green); }
.size-inputs span { font-size: 11px; color: var(--text-muted); font-weight: 600; }
/* ── Image Floating Resizer ── */
.img-resizer-floating {
  position: fixed; display: none; background: var(--surface); border: 1px solid var(--border);
  border-radius: 8px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); z-index: 200; padding: 10px;
  width: 180px; pointer-events: all;
}
.img-resizer-floating.show { display: block; }
.resizer-head { font-size: 9px; font-weight: 800; text-transform: uppercase; color: var(--text-muted); margin-bottom: 8px; letter-spacing: 0.5px; }
.resizer-input-group { display: flex; align-items: center; gap: 4px; margin-bottom: 8px; }
.resizer-input { flex: 1; min-width: 0; padding: 6px 8px; border: 1px solid var(--border); border-radius: 6px; font-size: 11px; outline: none; background: var(--bg); font-weight: 600; }
.resizer-input:focus { border-color: var(--green); }
.resizer-apply { background: var(--green); color: white; border: none; border-radius: 6px; padding: 6px 10px; cursor: pointer; transition: opacity 0.2s; }
.resizer-apply:hover { opacity: 0.8; }

.resizer-tools { display: grid; grid-template-columns: 1fr 1fr; gap: 4px; border-top: 1px solid var(--border); padding-top: 8px; }
.tool-btn { display: flex; align-items: center; justify-content: center; gap: 5px; padding: 6px; border: 1px solid var(--border); border-radius: 6px; background: var(--bg); color: var(--text-secondary); cursor: pointer; transition: all 0.15s; font-size: 10px; font-weight: 700; text-transform: uppercase; }
.tool-btn:hover { background: #fff; border-color: var(--green); color: var(--green); }
.tool-btn .material-symbols-rounded { font-size: 14px; }

/* ── Zoom Slider ── */
.resizer-slider-wrap { padding: 4px 0 10px; border-bottom: 1px solid var(--border); margin-bottom: 8px; }
.resizer-slider { width: 100%; height: 4px; background: var(--border); border-radius: 2px; outline: none; appearance: none; cursor: pointer; }
.resizer-slider::-webkit-slider-thumb { appearance: none; width: 12px; height: 12px; border-radius: 50%; background: var(--green); border: 2px solid #fff; box-shadow: 0 1px 3px rgba(0,0,0,0.2); }

.resizer-align-group { display: flex; gap: 4px; border-top: 1px solid var(--border); padding-top: 8px; }
.align-btn { flex: 1; display: flex; align-items: center; justify-content: center; padding: 6px; border: 1px solid var(--border); border-radius: 6px; background: var(--bg); color: var(--text-secondary); cursor: pointer; }
.align-btn:hover { background: #fff; color: var(--green); border-color: var(--green); }
.align-btn.active { background: var(--green-light); color: var(--green); border-color: var(--green); }
</style>


{{-- Image Resizer Floating UI --}}
<div id="imgResizerMenu" class="img-resizer-floating">
  <div class="resizer-head">Zoom / Ukuran</div>
  <div class="resizer-slider-wrap">
    <input type="range" id="resizerSlider" class="resizer-slider" min="10" max="100" step="1" value="100">
  </div>
  <div class="resizer-input-group">
    <input type="text" id="resizerValue" class="resizer-input" placeholder="px atau %">
    <button type="button" class="resizer-apply" onclick="applyImageResize()">
      <span class="material-symbols-rounded" style="font-size:14px;">check</span>
    </button>
  </div>
  <div class="resizer-tools">
    <button type="button" class="tool-btn" onclick="rotateImage()">
      <span class="material-symbols-rounded">rotate_right</span> Putar
    </button>
    <button type="button" class="tool-btn" onclick="startImageCrop()">
      <span class="material-symbols-rounded">crop</span> Potong
    </button>
  </div>
  <div class="resizer-align-group">
    <button type="button" class="align-btn" title="Rata Kiri (Teks di Samping)" onclick="alignImage('left')">
      <span class="material-symbols-rounded">format_align_left</span>
    </button>
    <button type="button" class="align-btn" title="Rata Tengah" onclick="alignImage('center')">
      <span class="material-symbols-rounded">format_align_center</span>
    </button>
    <button type="button" class="align-btn" title="Rata Kanan (Teks di Samping)" onclick="alignImage('right')">
      <span class="material-symbols-rounded">format_align_right</span>
    </button>
  </div>
</div>

{{-- Crop Modal --}}
<div id="cropperModal" class="modal-overlay">
  <div class="modal-box">
    <div class="modal-header">
      <h3><span class="material-symbols-rounded">crop</span> Potong Gambar</h3>
      <button type="button" class="modal-close" onclick="closeCropperModal()"><span class="material-symbols-rounded">close</span></button>
    </div>
    <div class="modal-body">
      <div class="cropper-container-wrapper">
        <img id="cropperImg" src="">
      </div>
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-outline" onclick="closeCropperModal()">Batal</button>
      <button type="button" class="btn btn-primary" onclick="finishCrop()">
        <span class="material-symbols-rounded" style="font-size:16px;">check</span> Terapkan Potongan
      </button>
    </div>
  </div>
</div>


{{-- ═══════ TOOLBAR ═══════ --}}
<div class="editor-toolbar" id="editorToolbar">
  {{-- Undo / Redo --}}
  <div class="tb-group">
    <button type="button" class="tb-btn" title="Undo" onclick="execCmd('undo')">
      <span class="material-symbols-rounded">undo</span>
    </button>
    <button type="button" class="tb-btn" title="Redo" onclick="execCmd('redo')">
      <span class="material-symbols-rounded">redo</span>
    </button>
  </div>

  {{-- Typography --}}
  <div class="tb-group">
    <div class="tb-dropdown">
      <button type="button" class="tb-btn" style="width:auto; padding:0 10px; gap:6px; font-size:11px; border:1px solid var(--border); margin:0 2px;" title="Jenis Font" onclick="toggleDropdown('fontMenu')">
        <span id="curFont" style="font-weight:700;">Plus Jakarta Sans</span>
        <span class="material-symbols-rounded" style="font-size:14px;">arrow_drop_down</span>
      </button>
      <div class="tb-dropdown-menu" id="fontMenu">
        <button type="button" class="tb-dropdown-item" onclick="execCmd('fontName','\'Plus Jakarta Sans\', sans-serif');closeDropdowns()">Plus Jakarta Sans</button>
        <button type="button" class="tb-dropdown-item" onclick="execCmd('fontName','serif');closeDropdowns()" style="font-family:serif">Serif</button>
        <button type="button" class="tb-dropdown-item" onclick="execCmd('fontName','monospace');closeDropdowns()" style="font-family:monospace">Monospace</button>
        <button type="button" class="tb-dropdown-item" onclick="execCmd('fontName','cursive');closeDropdowns()" style="font-family:cursive">Cursive</button>
      </div>
    </div>
    
    <div class="tb-dropdown">
      <button type="button" class="tb-btn" title="Heading" onclick="toggleDropdown('headingMenu')">
        <span class="material-symbols-rounded">title</span>
      </button>
      <div class="tb-dropdown-menu" id="headingMenu">
        <button type="button" class="tb-dropdown-item" onclick="execCmd('formatBlock','<p>');closeDropdowns()">Normal</button>
        <button type="button" class="tb-dropdown-item" onclick="execCmd('formatBlock','<h1>');closeDropdowns()"><b>H1 - Judul Utama</b></button>
        <button type="button" class="tb-dropdown-item" onclick="execCmd('formatBlock','<h2>');closeDropdowns()"><b>H2 - Sub Judul</b></button>
        <button type="button" class="tb-dropdown-item" onclick="execCmd('formatBlock','<h3>');closeDropdowns()"><b>H3 - Section</b></button>
      </div>
    </div>
  </div>

  {{-- Font Size --}}
  <div class="tb-group">
    <div class="tb-dropdown">
      <button type="button" class="tb-btn" title="Ukuran Font" onclick="toggleDropdown('fontSizeMenu')">
        <span class="material-symbols-rounded">format_size</span>
      </button>
      <div class="tb-dropdown-menu" id="fontSizeMenu"></div>
      <script>
      (function(){
        const sizes = [['1','10px'],['2','13px'],['3','16px'],['4','18px'],['5','24px'],['6','32px'],['7','48px']];
        const menu = document.getElementById('fontSizeMenu');
        sizes.forEach(function(fs){
          const btn = document.createElement('button');
          btn.type = 'button';
          btn.className = 'tb-dropdown-item';
          btn.onclick = function(){ execCmd('fontSize', fs[0]); closeDropdowns(); };
          btn.innerHTML = '<span style="font-size:'+fs[1]+';font-weight:600">Aa</span><span style="font-size:11px;color:var(--text-muted)">'+fs[1]+'</span>';
          menu.appendChild(btn);
        });
      })();
      </script>
    </div>
  </div>

  {{-- Text Formatting --}}
  <div class="tb-group">
    <button type="button" class="tb-btn" id="btnBold" title="Bold (Ctrl+B)" onclick="execCmd('bold')"><b>B</b></button>
    <button type="button" class="tb-btn" id="btnItalic" title="Italic (Ctrl+I)" onclick="execCmd('italic')"><i>I</i></button>
    <button type="button" class="tb-btn" id="btnUnderline" title="Underline (Ctrl+U)" onclick="execCmd('underline')"><u>U</u></button>
    <button type="button" class="tb-btn" id="btnStrike" title="Strikethrough" onclick="execCmd('strikeThrough')"><s>S</s></button>
  </div>

  {{-- Text Color --}}
  <div class="tb-group">
    <div class="tb-dropdown">
      <button type="button" class="tb-btn" title="Warna Teks" onclick="toggleDropdown('textColorMenu')">
        <span class="material-symbols-rounded">format_color_text</span>
      </button>
      <div class="tb-dropdown-menu" id="textColorMenu">
        <div class="color-grid" id="textColorGrid"></div>
      </div>
      <script>
      (function(){
        const colors = ['#000000','#434343','#666666','#999999','#b7b7b7','#cccccc','#d9d9d9','#ffffff','#980000','#ff0000','#ff9900','#ffff00','#00ff00','#00ffff','#4a86e8','#0000ff','#9900ff','#ff00ff','#e6b8af','#f4cccc','#fce5cd','#fff2cc','#d9ead3','#d0e0e3','#c9daf8','#cfe2f3','#d9d2e9','#ead1dc','#dd7e6b','#ea9999','#f9cb9c','#ffe599','#b6d7a8','#a2c4c9','#a4c2f4','#9fc5e8','#b4a7d6','#d5a6bd','#cc4125','#e06666','#f6b26b','#ffd966','#93c47d','#76a5af','#6d9eeb','#6fa8dc','#8e7cc3','#c27ba0','#a61c00','#cc0000','#e69138','#f1c232','#6aa84f','#45818e','#3c78d8','#3d85c6','#674ea7','#a64d79','#85200c','#990000','#b45f06','#bf9000','#38761d','#134f5c','#1155cc','#0b5394','#351c75','#741b47'];
        const grid = document.getElementById('textColorGrid');
        colors.forEach(function(c){
          const btn = document.createElement('button');
          btn.type = 'button';
          btn.className = 'color-swatch';
          btn.style.background = c;
          btn.onclick = function(){ execCmd('foreColor', c); closeDropdowns(); };
          grid.appendChild(btn);
        });
      })();
      </script>
    </div>

    <div class="tb-dropdown">
      <button type="button" class="tb-btn" title="Highlight" onclick="toggleDropdown('bgColorMenu')">
        <span class="material-symbols-rounded">format_color_fill</span>
      </button>
      <div class="tb-dropdown-menu" id="bgColorMenu">
        <div class="color-grid" id="bgColorGrid"></div>
      </div>
      <script>
      (function(){
        const bgs = ['transparent','#fef3c7','#fce7f3','#dbeafe','#dcfce7','#fef9c3','#ede9fe','#ffedd5','#fee2e2','#e0e7ff','#ccfbf1','#f3e8ff','#fff7ed','#fef2f2','#f0fdf4','#f5f3ff','#fffbeb'];
        const grid = document.getElementById('bgColorGrid');
        bgs.forEach(function(bg){
          const btn = document.createElement('button');
          btn.type = 'button';
          btn.className = 'color-swatch';
          btn.style.background = bg;
          if (bg === 'transparent') btn.style.border = '1px dashed var(--border)';
          btn.onclick = function(){ execCmd('hiliteColor', bg); closeDropdowns(); };
          grid.appendChild(btn);
        });
      })();
      </script>
    </div>
  </div>

  {{-- Alignment --}}
  <div class="tb-group">
    <button type="button" class="tb-btn" title="Rata Kiri" onclick="execCmd('justifyLeft')">
      <span class="material-symbols-rounded">format_align_left</span>
    </button>
    <button type="button" class="tb-btn" title="Rata Tengah" onclick="execCmd('justifyCenter')">
      <span class="material-symbols-rounded">format_align_center</span>
    </button>
    <button type="button" class="tb-btn" title="Rata Kanan" onclick="execCmd('justifyRight')">
      <span class="material-symbols-rounded">format_align_right</span>
    </button>
    <button type="button" class="tb-btn" title="Rata Penuh" onclick="execCmd('justifyFull')">
      <span class="material-symbols-rounded">format_align_justify</span>
    </button>
  </div>

  {{-- Lists --}}
  <div class="tb-group">
    <button type="button" class="tb-btn" title="Bullet List" onclick="execCmd('insertUnorderedList')">
      <span class="material-symbols-rounded">format_list_bulleted</span>
    </button>
    <button type="button" class="tb-btn" title="Numbered List" onclick="execCmd('insertOrderedList')">
      <span class="material-symbols-rounded">format_list_numbered</span>
    </button>
    <button type="button" class="tb-btn" title="Indent" onclick="execCmd('indent')">
      <span class="material-symbols-rounded">format_indent_increase</span>
    </button>
    <button type="button" class="tb-btn" title="Outdent" onclick="execCmd('outdent')">
      <span class="material-symbols-rounded">format_indent_decrease</span>
    </button>
  </div>

  {{-- Insert --}}
  <div class="tb-group">
    <button type="button" class="tb-btn" title="Garis Pembatas" onclick="execCmd('insertHorizontalRule')">
      <span class="material-symbols-rounded">horizontal_rule</span>
    </button>
    <button type="button" class="tb-btn" title="Blockquote" onclick="execCmd('formatBlock','<blockquote>')">
      <span class="material-symbols-rounded">format_quote</span>
    </button>
    <button type="button" class="tb-btn" title="Sisipkan Link" onclick="showLinkModal()">
      <span class="material-symbols-rounded">link</span>
    </button>
    <button type="button" class="tb-btn" title="Sisipkan Foto" onclick="showImageModal()">
      <span class="material-symbols-rounded">image</span>
    </button>
    <button type="button" class="tb-btn" title="Sisipkan Tabel" onclick="insertTable()">
      <span class="material-symbols-rounded">table_chart</span>
    </button>
  </div>

  {{-- Emoji --}}
  <div class="tb-group">
    <div class="tb-dropdown">
      <button type="button" class="tb-btn" title="Emoji" onclick="toggleDropdown('emojiMenu')">😊</button>
      <div class="tb-dropdown-menu" id="emojiMenu" style="right:0; left:auto;">
        <div class="emoji-grid" id="emojiGrid"></div>
      </div>
      <script>
      (function(){
        const emojis = ['😊','😂','🤣','❤️','😍','🙏','😢','😮','🔥','✅','⚠️','ℹ️','❌','💰','📢','📌','🎉','👍','👋','💪','🤝','📅','⏰','🏦','💵','📊','📈','📋','✉️','🔔','⭐','🏠','👥','📝','🎯','💡','🔒','✨','💫','🌟'];
        const grid = document.getElementById('emojiGrid');
        emojis.forEach(function(em){
          const btn = document.createElement('button');
          btn.type = 'button';
          btn.className = 'emoji-btn';
          btn.textContent = em;
          btn.onclick = function(){ insertEmoji(em); closeDropdowns(); };
          grid.appendChild(btn);
        });
      })();
      </script>
    </div>
  </div>

  {{-- Clean & Undo --}}
  <div class="tb-group">
    <button type="button" class="tb-btn" title="Hapus Format" onclick="execCmd('removeFormat')">
      <span class="material-symbols-rounded">format_clear</span>
    </button>
  </div>
</div>

{{-- ═══════ CONTENT EDITABLE ═══════ --}}
<div class="editor-content" id="editorContent" contenteditable="true"
     data-placeholder="Tulis isi informasi di sini...&#10;&#10;Gunakan toolbar di atas untuk memformat teks, sisipkan gambar, link, tabel, dan lainnya."
>{!! old('content', isset($informasi) ? $informasi->content : '') !!}</div>

{{-- Hidden input to hold content on submit --}}
<textarea name="content" id="hiddenContent" style="display:none;"></textarea>

{{-- ═══════ IMAGE MODAL ═══════ --}}
<div class="modal-overlay" id="imageModal">
  <div class="modal-box">
    <div class="modal-header">
      <h3><span class="material-symbols-rounded">image</span> Sisipkan Gambar</h3>
      <button class="modal-close" onclick="closeImageModal()"><span class="material-symbols-rounded">close</span></button>
    </div>
    <div class="modal-body">
      {{-- Upload --}}
      <div class="upload-zone" id="uploadZone" onclick="document.getElementById('imageFileInput').click()">
        <span class="material-symbols-rounded">cloud_upload</span>
        <p>Klik atau seret gambar ke sini</p>
        <p class="hint">JPG, PNG, GIF, WebP • Maks 5MB</p>
      </div>
      <input type="file" id="imageFileInput" accept="image/*" style="display:none;" onchange="handleImageUpload(this)"/>

      <div class="upload-progress" id="uploadProgress">
        <span style="font-size:11px; font-weight:600; color:var(--text-secondary);">Mengupload gambar...</span>
        <div class="bar-wrap"><div class="bar-fill" id="uploadBar"></div></div>
      </div>

      {{-- Or URL --}}
      <div style="text-align:center; font-size:11px; color:var(--text-muted); font-weight:600;">— atau masukkan URL —</div>
      <div class="url-input-wrap">
        <input type="text" id="imageUrlInput" placeholder="https://contoh.com/gambar.jpg"/>
        <button type="button" class="btn btn-primary" style="padding: 8px 14px; font-size:12px;" onclick="insertImageFromUrl()">Sisipkan</button>
      </div>

      {{-- Size options --}}
      <div class="form-group-sm">
        <label>Ukuran Gambar</label>
        <div class="size-inputs">
          <input type="number" id="imgWidth" placeholder="Lebar" value=""/>
          <span>×</span>
          <input type="number" id="imgHeight" placeholder="Tinggi" value=""/>
          <span>px</span>
          <select id="imgSizePreset" onchange="applyImagePreset(this.value)" style="padding:6px;border-radius:6px;border:1px solid var(--border);font-size:11px;">
            <option value="">Preset...</option>
            <option value="100%">Full Width</option>
            <option value="75%">75%</option>
            <option value="50%">50%</option>
            <option value="25%">25%</option>
            <option value="200">200px</option>
            <option value="400">400px</option>
          </select>
        </div>
      </div>
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-outline" style="font-size:12px;" onclick="closeImageModal()">Batal</button>
    </div>
  </div>
</div>

{{-- ═══════ LINK MODAL ═══════ --}}
<div class="modal-overlay" id="linkModal">
  <div class="modal-box">
    <div class="modal-header">
      <h3><span class="material-symbols-rounded">link</span> Sisipkan Link</h3>
      <button class="modal-close" onclick="closeLinkModal()"><span class="material-symbols-rounded">close</span></button>
    </div>
    <div class="modal-body">
      <div class="form-group-sm">
        <label>Teks Link</label>
        <input type="text" id="linkText" placeholder="Teks yang ditampilkan..."/>
      </div>
      <div class="form-group-sm">
        <label>URL</label>
        <input type="text" id="linkUrl" placeholder="https://..."/>
      </div>
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-outline" style="font-size:12px;" onclick="closeLinkModal()">Batal</button>
      <button type="button" class="btn btn-primary" style="font-size:12px;" onclick="insertLink()">Sisipkan Link</button>
    </div>
  </div>
</div>

<script>
const editor = document.getElementById('editorContent');
const hiddenContent = document.getElementById('hiddenContent');

// Sync content to hidden textarea before submit
function syncContent() {
  hiddenContent.value = editor.innerHTML;
}

// Attach to all parent forms
document.querySelectorAll('form').forEach(f => {
  f.addEventListener('submit', function(e) {
    syncContent();
    if (!editor.textContent.trim() && !editor.querySelector('img')) {
      e.preventDefault();
      alert('Konten informasi tidak boleh kosong!');
    }
  });
});

// execCommand wrapper
function execCmd(cmd, val = null) {
  editor.focus();
  document.execCommand(cmd, false, val);
  updateToolbarState();
}

// Update toolbar active states
function updateToolbarState() {
  const map = {
    'btnBold': 'bold',
    'btnItalic': 'italic',
    'btnUnderline': 'underline',
    'btnStrike': 'strikeThrough',
  };
  for (const [id, cmd] of Object.entries(map)) {
    const el = document.getElementById(id);
    if (el) el.classList.toggle('active', document.queryCommandState(cmd));
  }
}

editor.addEventListener('keyup', updateToolbarState);
editor.addEventListener('mouseup', updateToolbarState);
editor.addEventListener('input', updateToolbarState);

// Dropdown management
function toggleDropdown(id) {
  const menu = document.getElementById(id);
  const wasOpen = menu.classList.contains('show');
  closeDropdowns();
  if (!wasOpen) menu.classList.add('show');
}
function closeDropdowns() {
  document.querySelectorAll('.tb-dropdown-menu').forEach(m => m.classList.remove('show'));
}
document.addEventListener('click', function(e) {
  if (!e.target.closest('.tb-dropdown')) closeDropdowns();
});

// Emoji
function insertEmoji(emoji) {
  editor.focus();
  document.execCommand('insertText', false, emoji);
}

// Insert table
function insertTable() {
  editor.focus();
  const html = `<table><thead><tr><th>Kolom 1</th><th>Kolom 2</th><th>Kolom 3</th></tr></thead><tbody><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr></tbody></table><p>&nbsp;</p>`;
  document.execCommand('insertHTML', false, html);
}

// ── Image Modal ──
function showImageModal() {
  document.getElementById('imageModal').classList.add('show');
  document.getElementById('imageUrlInput').value = '';
  document.getElementById('imgWidth').value = '';
  document.getElementById('imgHeight').value = '';
  document.getElementById('imgSizePreset').value = '';
  document.getElementById('uploadProgress').style.display = 'none';
}
function closeImageModal() {
  document.getElementById('imageModal').classList.remove('show');
}

function applyImagePreset(val) {
  const w = document.getElementById('imgWidth');
  const h = document.getElementById('imgHeight');
  if (val.includes('%')) {
    w.value = val;
    h.value = 'auto';
  } else if (val) {
    w.value = val;
    h.value = '';
  }
}

function insertImageToEditor(url) {
  const w = document.getElementById('imgWidth').value;
  const h = document.getElementById('imgHeight').value;
  let style = '';
  if (w) style += w.includes('%') ? `width:${w};` : `width:${w}px;`;
  if (h && h !== 'auto') style += `height:${h}px;`;
  else if (w) style += 'height:auto;';

  editor.focus();
  const img = `<img src="${url}" style="${style || 'max-width:100%;height:auto;'}" alt="Gambar Informasi"/><p>&nbsp;</p>`;
  document.execCommand('insertHTML', false, img);
  closeImageModal();
}

function insertImageFromUrl() {
  const url = document.getElementById('imageUrlInput').value.trim();
  if (!url) { alert('Masukkan URL gambar!'); return; }
  insertImageToEditor(url);
}

// Upload image to server
function handleImageUpload(input) {
  const file = input.files[0];
  if (!file) return;

  const formData = new FormData();
  formData.append('image', file);
  formData.append('_token', '{{ csrf_token() }}');

  const progress = document.getElementById('uploadProgress');
  const bar = document.getElementById('uploadBar');
  progress.style.display = 'block';
  bar.style.width = '0%';

  const xhr = new XMLHttpRequest();
  xhr.upload.addEventListener('progress', function(e) {
    if (e.lengthComputable) bar.style.width = Math.round((e.loaded / e.total) * 100) + '%';
  });
  xhr.addEventListener('load', function() {
    bar.style.width = '100%';
    try {
      const res = JSON.parse(xhr.responseText);
      if (res.success && res.url) {
        setTimeout(() => {
          insertImageToEditor(res.url);
          progress.style.display = 'none';
          input.value = '';
        }, 300);
      } else {
        alert('Upload gagal: ' + (res.message || 'Terjadi kesalahan'));
        progress.style.display = 'none';
      }
    } catch(e) {
      alert('Upload gagal. Pastikan Anda sudah login.');
      progress.style.display = 'none';
    }
  });
  xhr.addEventListener('error', function() {
    alert('Upload gagal. Periksa koneksi.');
    progress.style.display = 'none';
  });
  xhr.open('POST', '{{ route("admin.informasi.uploadImage") }}');
  xhr.send(formData);
}

// Drag & drop on upload zone
const uploadZone = document.getElementById('uploadZone');
['dragenter','dragover'].forEach(e => uploadZone.addEventListener(e, function(ev) { ev.preventDefault(); this.classList.add('dragover'); }));
['dragleave','drop'].forEach(e => uploadZone.addEventListener(e, function(ev) { ev.preventDefault(); this.classList.remove('dragover'); }));
uploadZone.addEventListener('drop', function(e) {
  const file = e.dataTransfer.files[0];
  if (file && file.type.startsWith('image/')) {
    const input = document.getElementById('imageFileInput');
    const dt = new DataTransfer();
    dt.items.add(file);
    input.files = dt.files;
    handleImageUpload(input);
  }
});

// ── Link Modal ──
function showLinkModal() {
  const sel = window.getSelection();
  const text = sel.toString();
  document.getElementById('linkText').value = text;
  document.getElementById('linkUrl').value = '';
  document.getElementById('linkModal').classList.add('show');
}
function closeLinkModal() {
  document.getElementById('linkModal').classList.remove('show');
}
function insertLink() {
  const text = document.getElementById('linkText').value.trim();
  const url = document.getElementById('linkUrl').value.trim();
  if (!url) { alert('Masukkan URL!'); return; }
  editor.focus();
  const display = text || url;
  document.execCommand('insertHTML', false, `<a href="${url}" target="_blank" rel="noopener">${display}</a>`);
  closeLinkModal();
}

// ── Image click-to-resize in editor ──
editor.addEventListener('click', function(e) {
  // Deselect all images first
  editor.querySelectorAll('img.selected').forEach(i => i.classList.remove('selected'));
  if (e.target.tagName === 'IMG') {
    e.target.classList.add('selected');
  }
});

// Global keyboard shortcut for delete selected image
document.addEventListener('keydown', function(e) {
  // If the resizer input is focused, don't trigger global image deletion
  if (document.activeElement === document.getElementById('resizerValue')) return;

  if ((e.key === 'Delete' || e.key === 'Backspace') && editor.querySelector('img.selected') && document.activeElement !== editor) {
    editor.querySelector('img.selected').remove();
  }
});

// Image Resizer System
let currentResizingImg = null;
let cropperInstance = null;
const resizerMenu = document.getElementById('imgResizerMenu');
const resizerValue = document.getElementById('resizerValue');
const resizerSlider = document.getElementById('resizerSlider');

editor.addEventListener('contextmenu', function(e) {
  if (e.target.tagName === 'IMG') {
    e.preventDefault();
    currentResizingImg = e.target;
    
    // Position the menu at mouse cursor
    resizerMenu.style.left = e.clientX + 'px';
    resizerMenu.style.top = e.clientY + 'px';
    resizerMenu.classList.add('show');
    
    // Set current value
    const curWidth = currentResizingImg.style.width || '100%';
    resizerValue.value = curWidth;
    
    // Update slider if it's percentage
    if (curWidth.includes('%')) {
      resizerSlider.value = parseInt(curWidth);
    } else {
      resizerSlider.value = 100; // Reset slider if fixed px
    }
    
    resizerValue.focus();
    resizerValue.select();
  } else {
    resizerMenu.classList.remove('show');
  }
});

// Real-time slider zoom
resizerSlider.addEventListener('input', function() {
  if (!currentResizingImg) return;
  const val = this.value + '%';
  currentResizingImg.style.width = val;
  currentResizingImg.style.height = 'auto';
  resizerValue.value = val;
  syncContent();
});

function applyImageResize() {
  if (!currentResizingImg) return;
  const val = resizerValue.value.trim();
  if (val) {
    currentResizingImg.style.width = val.includes('%') ? val : val.replace(/[^0-9]/g, '') + 'px';
    currentResizingImg.style.height = 'auto';
  }
  resizerMenu.classList.remove('show');
  currentResizingImg = null;
}

// ── Rotate Image ──
function rotateImage() {
  if (!currentResizingImg) return;
  let currentRotation = parseInt(currentResizingImg.dataset.rotation || '0');
  currentRotation = (currentRotation + 90) % 360;
  currentResizingImg.dataset.rotation = currentRotation;
  currentResizingImg.style.transform = `rotate(${currentRotation}deg)`;
  
  // Basic padding/margin fix for rotated images to prevent overlapping text
  if (currentRotation === 90 || currentRotation === 270) {
    currentResizingImg.style.margin = '20px 0';
  } else {
    currentResizingImg.style.margin = '';
  }
}

// ── Align Image (Float) ──
function alignImage(align) {
  if (!currentResizingImg) return;
  
  if (align === 'left') {
    currentResizingImg.style.float = 'left';
    currentResizingImg.style.display = 'inline-block';
    currentResizingImg.style.margin = '0 15px 10px 0';
  } else if (align === 'right') {
    currentResizingImg.style.float = 'right';
    currentResizingImg.style.display = 'inline-block';
    currentResizingImg.style.margin = '0 0 10px 15px';
  } else {
    currentResizingImg.style.float = 'none';
    currentResizingImg.style.display = 'block';
    currentResizingImg.style.margin = '10px auto';
  }
  
  resizerMenu.classList.remove('show');
  syncContent();
}

// ── Crop Image ──
function startImageCrop() {
  if (!currentResizingImg) return;
  const modal = document.getElementById('cropperModal');
  const cropImg = document.getElementById('cropperImg');
  
  cropImg.src = currentResizingImg.src;
  modal.classList.add('show');
  resizerMenu.classList.remove('show');
  
  if (cropperInstance) cropperInstance.destroy();
  
  setTimeout(() => {
    cropperInstance = new Cropper(cropImg, {
      viewMode: 1,
      dragMode: 'move',
      autoCropArea: 0.8,
      restore: false,
      guides: true,
      center: true,
      highlight: false,
      cropBoxMovable: true,
      cropBoxResizable: true,
      toggleDragModeOnDblclick: false,
    });
  }, 100);
}

function closeCropperModal() {
  document.getElementById('cropperModal').classList.remove('show');
  if (cropperInstance) cropperInstance.destroy();
}

function finishCrop() {
  if (!cropperInstance || !currentResizingImg) return;
  
  const canvas = cropperInstance.getCroppedCanvas();
  const croppedDataUrl = canvas.toDataURL('image/png');
  
  // Ideally, we should upload the cropped version to the server
  // But for immediate UX, we replace the source with dataURL first
  // and we also send it to the server to get a real URL
  
  const formData = new FormData();
  fetch(croppedDataUrl)
    .then(res => res.blob())
    .then(blob => {
      formData.append('image', blob, 'cropped-image.png');
      formData.append('_token', '{{ csrf_token() }}');
      
      return fetch('{{ route("admin.informasi.uploadImage") }}', {
        method: 'POST',
        body: formData
      });
    })
    .then(res => res.json())
    .then(json => {
      if (json.success && json.url) {
        currentResizingImg.src = json.url;
      } else {
        currentResizingImg.src = croppedDataUrl; // Fallback to base64
      }
      closeCropperModal();
      currentResizingImg = null;
    })
    .catch(() => {
      currentResizingImg.src = croppedDataUrl;
      closeCropperModal();
    });
}

// Close resizer when clicking elsewhere
document.addEventListener('mousedown', function(e) {
  if (!resizerMenu.contains(e.target) && !e.target.closest('img')) {
    resizerMenu.classList.remove('show');
  }
});

// Resizer Enter Key
resizerValue.addEventListener('keydown', function(e) {
  if (e.key === 'Enter') {
    e.preventDefault();
    applyImageResize();
  }
});

// Double-click is now disabled or ignored to prioritize this new menu
editor.addEventListener('dblclick', function(e) {
  if (e.target.tagName === 'IMG') e.preventDefault();
});

// Prevent form submit on enter inside modals
document.querySelectorAll('.modal-overlay input').forEach(input => {
  input.addEventListener('keydown', function(e) {
    if (e.key === 'Enter') e.preventDefault();
  });
});

// Close modals on escape
document.addEventListener('keydown', function(e) {
  if (e.key === 'Escape') {
    closeImageModal();
    closeLinkModal();
    closeDropdowns();
  }
});

// Close modal on overlay click
document.querySelectorAll('.modal-overlay').forEach(m => {
  m.addEventListener('click', function(e) {
    if (e.target === this) {
      closeImageModal();
      closeLinkModal();
    }
  });
});

// Paste handling — strip complex formatting on paste
editor.addEventListener('paste', function(e) {
  // Allow image paste
  const items = e.clipboardData.items;
  for (let i = 0; i < items.length; i++) {
    if (items[i].type.startsWith('image/')) {
      e.preventDefault();
      const blob = items[i].getAsFile();
      const formData = new FormData();
      formData.append('image', blob, 'pasted-image.png');
      formData.append('_token', '{{ csrf_token() }}');

      const xhr = new XMLHttpRequest();
      xhr.addEventListener('load', function() {
        try {
          const res = JSON.parse(xhr.responseText);
          if (res.success && res.url) {
            document.execCommand('insertHTML', false, `<img src="${res.url}" style="max-width:100%;height:auto;" alt="Pasted Image"/>`);
          }
        } catch(err) {}
      });
      xhr.open('POST', '{{ route("admin.informasi.uploadImage") }}');
      xhr.send(formData);
      return;
    }
  }
});

// Initial sync for edit mode
if (editor.innerHTML.trim()) {
  syncContent();
}
</script>
