<template>
	<div class="program-editor-outer row">
		 
		<div class="col-xs-9 program-background">
			<div class="flex space-around">
				<div class="page-label">
					<span class="label label-default" v-text="getLeftPage"></span>
				</div>
				<div class="page-label">
					<span class="label label-default" v-text="getRightPage"></span>
				</div>
			</div>
			<div id="canvas-container"><canvas class="drop-shadow" ref="editorCanvas"></canvas></div>
		</div>
	</div>
</template>

<script>

export default {
	props: {
		token: String,
	},
	data () {
		return {
			editor: null,
			canvas: null,
			canvasContainer: null,

			saveTimeout: null,
			lastSavedTimestamp: null,
		}
	},
	mounted () {
		this.initializeCanvas();
	},
	computed: {
		lastSavedText() {
			if (this.lastSavedTimestamp == null) {
				return 'Ingen endringer lagret.'
			}
			let then = new Date(this.lastSavedTimestamp);
			return 'Sist lagret kl '+then.toTimeString().substring(0,5)+'.';
		}
	},
	methods: {
		requestSave () {
			if (this.saveTimeout) {	
				window.clearTimeout(this.saveTimeout);
			}
			this.saveTimeout = window.setTimeout(() => {
					this.saveProgram();
					this.saveTimeout = null;
				}, 500);
			
		},
		saveProgram () {
			let programData = [];
			this.pages.forEach(page => {
				let tempPage = [];
				page.forEach(element => {
					tempPage.push(element.toObject());
				});
				programData.push(tempPage);
			});
			$.post(this.saveEndpoint, { _token: this.token, programData: JSON.stringify(programData) }, (response) => {
				if (response.status == 'success') {
					this.lastSavedTimestamp = Date.now();
				}
			});
		},
		initializeCanvas() {
			this.canvas = this.$refs.editorCanvas;
			// Set base size to a4 screen dimensions
			this.editor = new ProgramEditor(this.canvas, this.baseResolution.x, this.baseResolution.y);
			this.canvasContainer = document.getElementById('canvas-container');
			// resize to fit window
			this.recalculateCanvasSize();
			let ro = new ResizeObserver(() => {
				this.recalculateCanvasSize();
			}).observe(this.canvasContainer);

			window.addEventListener('mousemove', (event) => {
				this.editor.handleMouseMove(event);
			});
			this.canvas.addEventListener('mousedown', (event) => {
				this.editor.handleMouseDown(event);
			});
		},
		recalculateCanvasSize() {
			let maxWidth, maxHeight;
			if (this.canvasContainer.offsetWidth > this.baseWidth) {
				maxWidth = this.baseWidth;
				maxHeight = this.baseHeight;
			} else {
				maxWidth = this.canvasContainer.offsetWidth;
				maxHeight = this.canvasContainer.offsetHeight;
			}

			let ratio = this.editor.baseWidth / this.editor.baseHeight;
			let canvas_height = maxHeight;
			let canvas_width = canvas_height * ratio;
			if (canvas_width > maxWidth) {
				canvas_width = maxWidth;
				canvas_height = canvas_width / ratio;
			}
			this.canvas.style.width = canvas_width+'px';
			this.canvas.style.height = canvas_height+'px';
		},
		getProgramData() {
			$.post(this.endpoint, {
				_token: this.token,
				program_id: this.programId,
			}, (response) => {
				this.handleProgramDataLoaded(JSON.parse(response));
			});
		},
		handleImageUpload(event, element) {
			let files = event.target.files;
			if (files.length <= 0) return;
			let imageFile = files[0];
			let fileReader = new FileReader();
			fileReader.onload = (e) => {
				element.setImageData(e.target.result);
			}
			fileReader.readAsDataURL(imageFile);
		},
		clampNumber(value, min, max) {
			let fixedValue = isNaN(parseInt(value)) ? 0 : value;
			return (fixedValue >= min ? (fixedValue <= max ? fixedValue : max) : min);
		}
	}
}
</script>