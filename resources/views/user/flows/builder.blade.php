@extends('layouts.main.app')

@section('head')
    <title>Flow Builder | Digioverse</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/jerosoler/Drawflow/dist/drawflow.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style>
        :root {
            --primary-color: #128C7E;
            --primary-light: #25D366;
            --border-color: #e2e8f0;
            --sidebar-width: 300px;
        }

        body {
            font-family: 'Inter', sans-serif;
            overflow: hidden;
        }

        .flow-container {
            display: flex;
            width: 100%;
            height: calc(100vh - 110px);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            overflow: hidden;
            background: white;
        }

        .sidebar-builder {
            width: var(--sidebar-width);
            background: #fff;
            border-right: 1px solid var(--border-color);
            display: flex;
            flex-direction: column;
            z-index: 20;
        }

        .sidebar-title {
            padding: 20px;
            font-weight: 700;
            color: var(--primary-color);
            border-bottom: 1px solid var(--border-color);
        }

        .drag-item {
            display: flex;
            align-items: center;
            padding: 14px 16px;
            margin: 8px;
            background: #fff;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            cursor: grab;
            font-weight: 600;
            color: #475569;
            transition: 0.2s;
        }

        .drag-item:hover {
            transform: translateX(5px);
            border-color: var(--primary-light);
            color: var(--primary-color);
            background: #f0fdf4;
        }

        .drawflow-wrapper {
            flex-grow: 1;
            position: relative;
            background: #efe7dd;
            background-image: radial-gradient(#cbd5e1 1.5px, transparent 1.5px);
            background-size: 30px 30px;
        }

        .drawflow-canvas {
            width: 100%;
            height: 100%;
        }

        /* Node Styling */
        .drawflow-node {
            background: #fff;
            border: 1px solid var(--primary-light);
            border-radius: 12px;
            width: 340px;
            padding: 0;
            overflow: hidden;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        .drawflow-node.selected {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 4px rgba(18, 140, 126, 0.2);
        }

        .node-header {
            padding: 12px 15px;
            color: white;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .node-body {
            padding: 15px;
            background: #fff;
        }

        .node-label {
            font-size: 11px;
            font-weight: 700;
            color: #64748b;
            text-transform: uppercase;
            margin-bottom: 4px;
            display: block;
            letter-spacing: 0.5px;
        }

        .node-input,
        .node-textarea,
        .node-select {
            width: 100%;
            padding: 10px;
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            margin-bottom: 12px;
            font-size: 13px;
            background: #f8fafc;
        }

        .node-input:focus,
        .node-textarea:focus {
            outline: none;
            border-color: var(--primary-light);
            background: white;
        }

        /* Specific Colors */
        .node-start .node-header {
            background: #1e293b;
        }

        .node-text .node-header {
            background: #128C7E;
        }

        .node-button .node-header {
            background: #d97706;
        }

        .node-media .node-header {
            background: #059669;
        }

        .node-card .node-header {
            background: #7c3aed;
        }

        .node-wait .node-header {
            background: #475569;
        }

        /* Image Preview */
        .meta-preview-box {
            height: 140px;
            background: #f1f5f9;
            border-radius: 8px;
            margin-bottom: 10px;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1px dashed #cbd5e1;
            position: relative;
        }

        .meta-preview-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: none;
        }

        .upload-spinner {
            display: none;
            position: absolute;
            color: var(--primary-color);
            font-size: 24px;
        }

        /* Upload Button */
        .btn-upload-trigger {
            width: 100%;
            padding: 8px;
            border: 1px dashed #ccc;
            text-align: center;
            cursor: pointer;
            border-radius: 6px;
            font-size: 12px;
            color: #666;
            background: #fafafa;
        }

        .btn-upload-trigger:hover {
            background: #f0f0f0;
            border-color: #999;
        }

        .hidden-file-input {
            display: none;
        }
    </style>
@endsection

@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-header border-bottom-0 pb-3">
                <input type="text" id="flow_name" class="form-control"
                    style="width: 300px; font-weight: bold; border:none; background:transparent; font-size: 1.2rem;"
                    value="{{ $flow->name ?? 'New Automation Flow' }}" placeholder="Name your flow...">

                <input type="hidden" id="flow_id" value="{{ $flow->id ?? '' }}">

                <div class="ml-auto d-flex align-items-center">
                    {{-- BACK BUTTON --}}
                    <a href="{{ route('user.flows.index') }}" class="btn btn-secondary btn-sm mr-2 shadow-sm"
                        style="background:white; color:#333; border:1px solid #ddd;">
                        <i class="fas fa-arrow-left mr-1"></i> Back
                    </a>

                    <button class="btn btn-outline-danger btn-sm mr-2" onclick="editor.clearModuleSelected()">Clear</button>
                    <button class="btn btn-success shadow-sm px-4" id="saveBtn"
                        style="background-color: var(--primary-color);" onclick="saveFlow()">
                        <i class="fas fa-save mr-2"></i> Save
                    </button>
                </div>
            </div>

            <div class="section-body">
                <div class="flow-container">
                    <div class="sidebar-builder">
                        <div class="sidebar-title">Toolkit</div>

                        <div class="sidebar-section p-3 border-bottom">
                            <div class="node-label">Basic</div>
                            <div class="drag-item" draggable="true" ondragstart="drag(event)" data-node="text">
                                <i class="fas fa-comment text-success mr-2"></i> Text Message
                            </div>
                            <div class="drag-item" draggable="true" ondragstart="drag(event)" data-node="image">
                                <i class="fas fa-image text-success mr-2"></i> Image + Caption
                            </div>
                        </div>

                        <div class="sidebar-section p-3 border-bottom">
                            <div class="node-label">Interactive</div>
                            <div class="drag-item" draggable="true" ondragstart="drag(event)" data-node="buttons">
                                <i class="fas fa-list-ul text-warning mr-2"></i> Buttons (With Text)
                            </div>
                            <div class="drag-item" draggable="true" ondragstart="drag(event)" data-node="meta_card">
                                <i class="fas fa-gem text-purple mr-2"></i> Super Rich Card
                            </div>
                        </div>

                        <div class="sidebar-section p-3">
                            <div class="node-label">Logic</div>
                            <div class="drag-item" draggable="true" ondragstart="drag(event)" data-node="wait">
                                <i class="fas fa-clock text-secondary mr-2"></i> Delay / Wait
                            </div>
                        </div>
                    </div>

                    <div class="drawflow-wrapper">
                        <div id="drawflow" class="drawflow-canvas"></div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <script src="https://cdn.jsdelivr.net/gh/jerosoler/Drawflow/dist/drawflow.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        var id = document.getElementById("drawflow");
        const editor = new Drawflow(id);
        editor.reroute = true;
        editor.start();

        // --- TEMPLATES ---
        const startHtml = `
            <div class="node-header"><i class="fab fa-whatsapp"></i> TRIGGER</div>
            <div class="node-body">
                <label class="node-label">Keyword</label>
                <input type="text" df-key="keyword" class="node-input" placeholder="e.g. promo">
                <label class="node-label">Condition</label>
                <select df-key="condition" class="node-select">
                    <option value="equal">Exact Match</option>
                    <option value="contains">Contains</option>
                </select>
            </div>`;

        const textHtml = `
            <div class="node-header"><i class="fas fa-comment-alt"></i> Text Message</div>
            <div class="node-body">
                <label class="node-label">Message Content</label>
                <textarea df-key="message" class="node-textarea" rows="4" placeholder="Type here..."></textarea>
            </div>`;

        const buttonsHtml = `
            <div class="node-header"><i class="fas fa-list-ul"></i> Button Options</div>
            <div class="node-body">
                <label class="node-label">Header</label>
                <input type="text" df-key="header" class="node-input" placeholder="Title">

                <label class="node-label">Body Description</label>
                <textarea df-key="description" class="node-textarea" rows="2" placeholder="Description..."></textarea>

                <hr style="border-top:1px dashed #ddd; margin:10px 0;">

                <label class="node-label text-warning">Button 1</label>
                <input type="text" df-key="btn1" class="node-input" placeholder="Yes">

                <label class="node-label text-warning">Button 2</label>
                <input type="text" df-key="btn2" class="node-input" placeholder="No">

                <label class="node-label text-warning">Button 3</label>
                <input type="text" df-key="btn3" class="node-input" placeholder="Maybe">
            </div>`;

        const imageHtml = `
            <div class="node-header"><i class="fas fa-image"></i> Image + Caption</div>
            <div class="node-body">
                <div class="meta-preview-box">
                    <i class="fas fa-spinner fa-spin upload-spinner"></i>
                    <img src="" class="meta-card-img meta-preview-img">
                    <span class="placeholder-text" style="font-size:12px; color:#aaa">Preview</span>
                </div>

                <label class="btn-upload-trigger">
                    <i class="fas fa-upload"></i> Upload Image
                    <input type="file" class="hidden-file-input" onchange="uploadFile(this)" accept="image/*">
                </label>
                <input type="hidden" df-key="image_url" class="node-input url-input">

                <label class="node-label mt-3">Caption</label>
                <textarea df-key="caption" class="node-textarea" rows="2" placeholder="Type text to show below image..."></textarea>
            </div>`;

        const cardHtml = `
            <div class="node-header"><i class="fas fa-gem"></i> Super Rich Card</div>
            <div class="node-body">
                <div class="meta-preview-box">
                    <i class="fas fa-spinner fa-spin upload-spinner"></i>
                    <img src="" class="meta-card-img meta-preview-img">
                    <span class="placeholder-text" style="font-size:12px; color:#aaa">Header Image</span>
                </div>

                <label class="btn-upload-trigger">
                    <i class="fas fa-upload"></i> Upload Header
                    <input type="file" class="hidden-file-input" onchange="uploadFile(this)" accept="image/*">
                </label>
                <input type="hidden" df-key="image_url" class="node-input url-input">

                <label class="node-label mt-2">Title (Bold)</label>
                <input type="text" df-key="title" class="node-input font-weight-bold" placeholder="Super Offer!">

                <label class="node-label">Body Text</label>
                <textarea df-key="description" class="node-textarea" rows="3" placeholder="Enter details..."></textarea>

                <label class="node-label">Footer</label>
                <input type="text" df-key="footer" class="node-input" placeholder="e.g. Powered by Hosterlo">

                <hr style="border-top:1px dashed #ddd; margin:10px 0;">

                <label class="node-label text-purple">Buttons</label>
                <input type="text" df-key="btn1" class="node-input" placeholder="Button 1">
                <input type="text" df-key="btn2" class="node-input" placeholder="Button 2">
                <input type="text" df-key="btn3" class="node-input" placeholder="Button 3">
            </div>`;

        const waitHtml = `
            <div class="node-header">Wait</div>
            <div class="node-body">
                <label class="node-label">Seconds</label>
                <input df-key="seconds" type="number" class="node-input" value="5"> 
            </div>`;

        // --- LOADER ---
        @if(isset($flow) && !empty($flow->flow_data))
            try {
                const savedData = {!! $flow->flow_data !!};
                editor.import(savedData);
                // Restore images
                setTimeout(() => {
                    const nodes = editor.drawflow.drawflow.Home.data;
                    for (let id in nodes) {
                        if (nodes[id].data.image_url) {
                            const el = document.getElementById('node-' + id);
                            if (el) {
                                const img = el.querySelector('.meta-preview-img');
                                if (img) {
                                    img.src = nodes[id].data.image_url;
                                    img.style.display = 'block';
                                    el.querySelector('.placeholder-text').style.display = 'none';
                                }
                            }
                        }
                    }
                }, 500);
            } catch (e) {
                addStartNode();
            }
        @else
            addStartNode();
        @endif

        function addStartNode() {
            editor.addNode('start', 0, 1, 50, 300, 'node-start', { keyword: '', condition: 'equal' }, startHtml);
        }

        // --- DRAG AND DROP ---
        window.drag = function (ev) { ev.dataTransfer.setData("node", ev.target.getAttribute('data-node')); }
        window.drop = function (ev) {
            ev.preventDefault();
            var nodeType = ev.dataTransfer.getData("node");
            addNodeToCanvas(nodeType, ev.clientX, ev.clientY);
        }
        id.addEventListener("dragover", function (e) { e.preventDefault(); }, false);
        id.addEventListener("drop", window.drop, false);

        function addNodeToCanvas(name, posx, posy) {
            posx = posx * (editor.precanvas.clientWidth / (editor.precanvas.clientWidth * editor.zoom)) - (editor.precanvas.getBoundingClientRect().x * (editor.precanvas.clientWidth / (editor.precanvas.clientWidth * editor.zoom)));
            posy = posy * (editor.precanvas.clientHeight / (editor.precanvas.clientHeight * editor.zoom)) - (editor.precanvas.getBoundingClientRect().y * (editor.precanvas.clientHeight / (editor.precanvas.clientHeight * editor.zoom)));

            if (name === 'text') editor.addNode('text', 1, 1, posx, posy, 'node-text', { message: '' }, textHtml);
            if (name === 'buttons') editor.addNode('buttons', 1, 3, posx, posy, 'node-button', { header: '', description: '', btn1: '', btn2: '', btn3: '' }, buttonsHtml);
            if (name === 'image') editor.addNode('image', 1, 1, posx, posy, 'node-media', { image_url: '', caption: '' }, imageHtml);
            if (name === 'meta_card') editor.addNode('meta_card', 1, 3, posx, posy, 'node-card', { title: '', description: '', footer: '', image_url: '', btn1: '', btn2: '', btn3: '' }, cardHtml);
            if (name === 'wait') editor.addNode('wait', 1, 1, posx, posy, 'node-wait', { seconds: 5 }, waitHtml);
        }

        // --- REAL IMAGE UPLOAD FUNCTION ---
        window.uploadFile = function (input) {
            if (input.files && input.files[0]) {
                var node = input.closest('.drawflow-node');
                var spinner = node.querySelector('.upload-spinner');
                var img = node.querySelector('.meta-preview-img');
                var placeholder = node.querySelector('.placeholder-text');
                var hiddenInput = node.querySelector('.url-input');

                // Show Loading
                spinner.style.display = 'block';
                placeholder.style.display = 'none';
                img.style.display = 'none';

                var formData = new FormData();
                formData.append('image', input.files[0]);

                fetch('{{ route('user.flows.upload') }}', {
                    method: 'POST',
                    headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') },
                    body: formData
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.url) {
                            img.src = data.url;
                            img.style.display = 'block';
                            hiddenInput.value = data.url;
                            updateData(hiddenInput);
                        } else {
                            alert('Upload Failed');
                        }
                    })
                    .catch(err => console.error(err))
                    .finally(() => { spinner.style.display = 'none'; });
            }
        }

        // --- DATA BINDING ---
        id.addEventListener('input', function (e) {
            if (e.target.matches('[df-key]')) updateData(e.target);
        });
        id.addEventListener('change', function (e) {
            if (e.target.matches('select[df-key]')) updateData(e.target);
        });

        function updateData(element) {
            const node = element.closest('.drawflow-node');
            const nodeId = node.id.slice(5);
            const key = element.getAttribute('df-key');
            if (!editor.drawflow.drawflow.Home.data[nodeId].data) editor.drawflow.drawflow.Home.data[nodeId].data = {};
            editor.drawflow.drawflow.Home.data[nodeId].data[key] = element.value;
        }

        id.addEventListener('keydown', function (e) {
            if (e.target.matches('input') || e.target.matches('textarea')) e.stopPropagation();
        });

        // --- SAVE ---
        function saveFlow() {
            var exportData = editor.export();
            var name = document.getElementById('flow_name').value;
            var id = document.getElementById('flow_id').value;
            var btn = document.getElementById('saveBtn');

            btn.innerHTML = 'Saving...';
            btn.disabled = true;

            fetch('{{ route('user.flows.store') }}', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') },
                body: JSON.stringify({ id: id, name: name, flow_data: exportData })
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        document.getElementById('flow_id').value = data.id;
                        Swal.fire('Saved!', 'Flow saved successfully.', 'success');
                    } else {
                        Swal.fire('Error', data.message, 'error');
                    }
                })
                .catch(err => Swal.fire('Error', 'Server Error', 'error'))
                .finally(() => { btn.innerHTML = '<i class="fas fa-save mr-2"></i> Save'; btn.disabled = false; });
        }
    </script>
@endsection