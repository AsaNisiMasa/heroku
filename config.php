<?php
if(isset($_POST['mapa'])){
	
}
?>




<!doctype html>
<html>
<head>
    <title>Proyecto Delfos</title>
	<link rel='stylesheet' type='text/css' href='css/style.css' />
	<link rel='stylesheet' type='text/css' href='css/style_config.css' />   
	
	<script type="text/javascript" src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
	
	
</head>
<body>
	
	<div id="triangulo">
    	<canvas id='myCanvas'></canvas>
	</div>
	<div id="alertas">Prueba de que existo</div>
	
	<div id="config">
		<form method="POST">
			N:<input type="text" name="N"></input>
			<input type="hidden" name="mapa" value=""></input>
		</form>
	</div>

	
<script>

	var r3 = Math.sqrt(3);
	
	var A = 340;
    var B = 300;

	var canvas = document.getElementById('myCanvas');
	
	context = canvas.getContext("2d");
	
	with(canvas){
        setAttribute("width", A);
        setAttribute("height", B);
    }


	
	function drawPoint(cx, cy) {
	
		with(context){
            strokeStyle = "#ff0000";
            lineWidth = "1";

			

			beginPath();
			arc(cx, B-cy, 5, 0, Math.PI*2, true);
			stroke();
			fillStyle = "#ff0000";
			fill();
			

		}
	}
	
	function drawShape(shape){
		
		var coords="";
					
		if((shape.length)%2 != 0){
			//Error
		}
		else{
			var n = (shape.length)/2;
			with(context){

				strokeStyle = "#000000";
		        lineWidth = "3";
				
				for(var i = 0; i <= 2*n-2; i=i+2){
							
					coordx = shape[i];
					coordy = B - shape[i+1];
					if(i==0){
						coords+=coordx.toString()+","+coordy.toString();
						moveTo(coordx, coordy);
					}
					
					else{
						coords+=" , "+coordx.toString()+","+coordy.toString();
						lineTo(coordx, coordy);
					}
				}

				lineTo(shape[0], B-shape[1]);
				stroke();
			}
		}
		return coords;
	}
	
	function drawCircle (cx, cy, r) {
		with(context){
			lineWidth = "2";
			beginPath();
			arc(cx, B-cy, r, 0, Math.PI*2, true);
			stroke();
		}
	}
	
	function draw_Point(cx, cy, color, radius) {
	
		with(context){
            strokeStyle = color;
            lineWidth = "1";

			

			beginPath();
			arc(cx, B-cy, radius, 0, Math.PI*2, true);
			fillStyle = color;
			fill();
			stroke();
					
		}
	}
	
	function drawNum (cx, cy, num){
		with(context){
			fillStyle ="#000000";
			font = "bold 12px Arial";
		  	fillText(num, cx-6, B-cy+6);
		}
	}
	
	function getShapeLS (cx, cy, g, d) {
		
		return [cx+d/4-r3*g/2, cy + d*r3/4+g/2,
				cx+d/4, cy + d*r3/4,
				cx-d/4, cy - d*r3/4,
				cx-d/4-r3*g/2, cy - d*r3/4+g/2];
	}
	
	function getShapeRS (cx, cy, g, d) {
		
		return [cx-d/4, cy + d*r3/4,
				cx-d/4+r3*g/2, cy + d*r3/4+g/2,
				cx+d/4+r3*g/2, cy - d*r3/4+g/2,
				cx+d/4, cy - d*r3/4];
	}
	
	function getShapeBS (cx, cy, g, d) {
		return [cx-d/2, cy - g,
				cx-d/2, cy,
				cx+d/2, cy,
				cx+d/2, cy - g];
	}
	
	function getShapeVS (cx, cy, g, d) {
		return [cx, cy,
				cx-d/4, cy-d*r3/4,
				cx-d/4-r3*g/2, cy - d*r3/4+g/2,
				cx, cy + 2*g,
				cx+d/4+r3*g/2, cy - d*r3/4+g/2,
				cx+d/4, cy - d*r3/4];
	}
	
	function getShapeVL (cx, cy, g, d) {
		return [cx, cy,
				cx+d/4, cy + d*r3/4,
				cx+d/4-r3*g/2, cy + d*r3/4+g/2,
				cx-r3*g, cy - g,
				cx+d/2, cy - g,
				cx+d/2, cy
				];
	}
	
	function getShapeVR (cx, cy, g, d) {
		return [cx, cy,
				cx-d/4, cy + d*r3/4,
				cx-d/4+r3*g/2, cy + d*r3/4+g/2,
				cx+r3*g, cy - g,
				cx-d/2, cy - g,
				cx-d/2, cy
				];
	}
	
	function getShapeTR (cx, cy, d){
		return [cx-d/2, cy-d*r3/6,
				cx, cy+d*r3/3,
				cx+d/2, cy-d*r3/6];
	}
	
	function getShapeTI (cx, cy, d){
		return [cx-d/2, cy+d*r3/6,
				cx+d/2, cy+d*r3/6,
				cx, cy-d*r3/3];
	}
	
	function getProbs(x, y, l) { // ¡Cuidado con el offset!
		
		var val1 = 1 - x/l - y/(r3*l); // Peso correspondiente a "1";
		var valx = 2*y/(r3*l); // Peso correspondiente a "x";
		var val2 = x/l - y/(r3*l); // Peso correspondiente a "2";
		
		return 'val_1="' + Math.abs(val1).toFixed(2) + '" val_x="' + Math.abs(valx).toFixed(2) + '" val_2="' + Math.abs(val2).toFixed(2) + '"';
		
	}
	
	function generateAreaCode(x, y, d, coords, pos){
		
		return '<area  href="javascript:void(0)" shape="poly" coords="' + coords + '" pos="' + pos + '" ' + getProbs(x, y, d) + '/>';
		
	}
	
	
	var L = 270; // Lado del triángulo principal.
	
	var offx = 35; //
	var offy = 25; // Posición del vértice inferior-izquierdo del triángulo principal.
	
	var H = (L*r3)/2; // Altura del triángulo principal.
	
	var CX = offx + L/2;
	var CY = offy + H/3; // Centro del triángulo principal.
		
	// Puntos clave:
	
	draw_Point(CX-L/2, CY-H/3, "#0000ff", 10);
	draw_Point(CX, CY+2*H/3, "#0000ff", 10);
	draw_Point(CX+L/2, CY-H/3, "#0000ff", 10); // Vértices



	draw_Point(offx+L/4, offy+H/2, "#0000ff", 10);
	draw_Point(offx+3*L/4, offy+H/2, "#0000ff", 10);
	draw_Point(offx+L/2, offy, "#0000ff", 10); // Puntos medios de los lados;
	
	draw_Point(CX, CY, "#0000ff", 10); // Centro
	
	draw_Point(offx+L/2, offy+2*H/3, "#0000ff", 10);
	draw_Point(offx+L/4, offy+H/6, "#0000ff", 10);
	draw_Point(offx+3*L/4, offy+H/6, "#0000ff", 10); // Puntos intermedios centro-vértices.
	
	var mapa = "";

	
	var N =	9; //<?php echo (isset($_POST['N'])) ? mysql_real_escape_string($_POST['N']):0;?>; // Número de divisiones de cada lado del triángulo.
	
	var l = L/(N+1); // Longitud de cada división del triángulo principal.
	var h = H/(N+1);
	
	var G = 15;

	var R = l/4;

	var cx,
		cy,
		i=0;
	
	var n = 1;
	
		cx = CX;
		cy = CY + 2*H/3;
		//drawPoint(cx, cy);
		i++;
		mapa += generateAreaCode((cx-offx), (cy-offy), L, drawShape(getShapeVS(cx,cy,G,l)), i) + '\n';
		drawNum(cx,cy,i);
		
	
	for (n=2; n<=(N+2); n++){
		
		for (var m=1; m<=(2*n-1) ; m++) {


			switch(m){
			
				case 1:
				
					if(n!=N+2){
						cx = CX - (n-1)*l/2;
						cy = CY + 2*H/3 - (n-1)*h;
						//drawPoint(cx, cy);
						i++;
						mapa += generateAreaCode((cx-offx), (cy-offy), L, drawShape(getShapeLS(cx,cy,G,l)), i) + '\n';
						drawNum(cx,cy,i);
					}
					break;
					
				case 2*n-1:
					if(n!=N+2){
						cx = CX + (n-1)*l/2;
						cy = CY + 2*H/3 - (n-1)*h;
						//drawPoint(cx, cy);
						i++;
						drawNum(cx,cy,i);
						mapa += generateAreaCode((cx-offx), (cy-offy), L, drawShape(getShapeRS(cx,cy,G,l)), i) + '\n';
						
						
					}
					break;				
			
				default:
					if(m % 2 == 0){
						cx = CX - (n-2)*l/2 + (m-2)*l/2;
						cy = CY + 2*H/3 - (n-1)*h + h/3;
						i++;
						drawNum(cx,cy,i);
						mapa += generateAreaCode((cx-offx), (cy-offy), L, drawShape(getShapeTR(cx,cy,l)), i) + '\n';
						//drawShape(getShapeTR(cx,cy,l));
		
					}
					else{
						cx = CX - (n-2)*l/2 + (m-2)*l/2;
						cy = CY + 2*H/3 - (n-1)*h + 2*h/3;
						i++;
						drawNum(cx,cy,i);
						mapa += generateAreaCode((cx-offx), (cy-offy), L, drawShape(getShapeTI(cx,cy,l)), i) + '\n';		
					}

			
					//drawPoint(cx, cy);

					break;
			}

			
		}
	
		if(n == N+2){
			
			for (var m=1; m<=N+2 ; m++){
				
				cx = CX - (n-1)*l/2 + (m-1)*l;
				cy = CY - H/3;
				//drawPoint(cx, cy);
				i++;
				
				drawNum(cx,cy,i);
				
				switch (m){
					case 1:
					
						mapa += generateAreaCode((cx-offx), (cy-offy), L, drawShape(getShapeVL(cx,cy,G,l)), i) + '\n';
						break;
					case N+2:
						mapa += generateAreaCode((cx-offx), (cy-offy), L, drawShape(getShapeVR(cx,cy,G,l)), i) + '\n';
						break;
					default:
						mapa += generateAreaCode((cx-offx), (cy-offy), L, drawShape(getShapeBS(cx,cy,G,l)), i) + '\n';
						break;
				}
			}
		}
		
	}
	
	$('input[name=mapa]').attr('value', mapa);
	
	

</script>

</body>
</html>