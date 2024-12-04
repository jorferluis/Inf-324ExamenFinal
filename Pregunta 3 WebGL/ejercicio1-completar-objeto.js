var camera, scene, renderer;
var cameraControls;
var clock = new THREE.Clock();

function init() {
    var canvasWidth = window.innerWidth * 0.9;
    var canvasHeight = window.innerHeight * 0.9;

    // CAMERA
    camera = new THREE.PerspectiveCamera(45, canvasWidth / canvasHeight, 1, 80000);
    camera.position.set(0, 0, 3); // Ajustar la posición de la cámara
    camera.lookAt(0, 0, 0); // Cámara mirando al origen

    // RENDERER
    renderer = new THREE.WebGLRenderer({ antialias: true });
    renderer.setSize(canvasWidth, canvasHeight);
    renderer.setClearColor(0xAAAAAA, 1.0);

    // Add to DOM
    var container = document.getElementById('container');
    container.appendChild(renderer.domElement);

    // CONTROLS
    cameraControls = new THREE.OrbitControls(camera, renderer.domElement);
    cameraControls.target.set(0, 0, 0); // Cámara mirando al origen

    // TRIÁNGULO - Geometría
    var migeometria = new THREE.Geometry();

    // Definir los vértices
    migeometria.vertices.push(new THREE.Vector3(-0.5, 0, 0)); // Vértice 0
    migeometria.vertices.push(new THREE.Vector3(0.5, 0, 0));  // Vértice 1
    migeometria.vertices.push(new THREE.Vector3(0, 1, 0));    // Vértice 2

    // Definir la cara del triángulo (una sola cara)
    migeometria.faces.push(new THREE.Face3(0, 1, 2));

    // Calcular normales (opcional, pero útil si decides usar materiales que necesiten iluminación)
    migeometria.computeFaceNormals();

    // Crear el material con color morado
    var material = new THREE.MeshBasicMaterial({ color: 0x8000FF, side: THREE.DoubleSide });

    // Crear el objeto 3D
    var miobjeto = new THREE.Mesh(migeometria, material);

    // SCENE
    scene = new THREE.Scene();
    scene.add(miobjeto);
}

function animate() {
    window.requestAnimationFrame(animate);
    render();
}

function render() {
    var delta = clock.getDelta();
    cameraControls.update(delta);
    renderer.render(scene, camera);
}

try {
    init();
    animate();
} catch (e) {
    var errorReport = "Your program encountered an unrecoverable error, can not draw on canvas. Error was:<br/><br/>";
    document.getElementById('container').innerHTML = errorReport + e;
}
