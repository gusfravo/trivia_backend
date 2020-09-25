<html>
  <head>

    <style type="text/css" media="screen">
      body { margin: 0; font-family: Roboto, "Helvetica Neue", sans-serif; }
      .logos{
    		height: 3.1rem;
    		margin: 5px;
        display: inline-block;
    	}
    .imgcontainer{
    	margin: auto;
    	overflow: hidden;
        position: relative;
    	height: 15vh;
    	width: 15vh;
        background-image: url({{ $request['img'] }});
        background-position: center;
        background-repeat: no-repeat;
        background-size: 102%;
        border-radius: 50%;
        margin-bottom: 4%;
        box-shadow: 0px 0px 0px 8px rgba(189, 189, 189, 0.18);
    }
    .card_box{
    	background-color: #fff;
    	border-radius: 3vh;
    	box-shadow: 0px 5px 0px 0px rgba(134, 134, 134, 0.58);
    	animation: ent-cbox 1s ease-in-out;
    	transform-style: preserve-3d;
    	transition: all 1s ease-in-out;
      width: 600px;
      padding: 20px 30px;
    }

    .text-final {
        font-weight: bold;
        font-size: x-large;
        color: #0c758d;
    }

    .text {
        font-weight: bold;
        font-size: medium;
        color: #5a5a5a;
        margin-top: 5px;
    }
    </style>

  </head>

  <body>
  <div class="container card_box">
    <div class="row justify-content-center">
    	<div class="col-11" id="demo">
    			<div class="row" style="text-align: center;">
    				<div class="logos"><img src="/assets/img/logo-OLTTO.png" alt="" style="height:100%;"></div>
    				<div class="logos" style="margin-top:5px;"><img src="/assets/img/logo-sectur.png" alt="" style="height:70%;"></div>
    				<div class="logos" style="margin-top:5px;"><img src="/assets/img/Oaxacavivelo-01.png" alt="" style="height:85%;"></div>
    				<div class="logos" style="margin-top:5px;"><img src="/assets/img/volaris.png" alt="" style="height:70%;"></div>
    				<div class="logos" style="margin-top:5px;"><img src="/assets/img/LOGO_AM.png" alt="" style="height:70%;"></div>
    				<div class="logos" style="margin-top:12px;"><img src="/assets/img/aeromar-logo-completo_azules.png" alt="" style="height:45%;"></div>
    				<div class="logos" style="margin-top:-10px;"><img src="/assets/img/Logo_GFA_Oaxaca.png" alt="" style="height:77%;"></div>
    				<div class="logos" style="margin-top:-12px;"><img src="/assets/img/VIVO-RESORTS.png" alt="" style="height:70%;"></div>
    				<div class="logos" style="margin-top:-12px;"><img src="/assets/img/logo-AMHYMO.jpg" alt="" style="height:90%;"></div>
    				<div class="logos" style="margin-top:-12px;"><img src="/assets/img/LOGO-HYMVANTEQUERA.jpg" alt="" style="height:90%;"></div>
    				<div class="logos" style="margin-top:-5px;"><img src="/assets/img/unnamed.png" alt="" style="height:55%;"></div>
    			</div>

    			<div class="row justify-content-center">
    				<div class="col-11" style="text-align: center; background-image: url(/assets/img/fiesta.png); background-repeat: no-repeat; background-position: center;">

    		 			<div class="text-final">
    		                ¡Felicidades!
    		            </div>
    					<div class="text">
    		                Has terminado el Rally Turístico
    		            </div>

    					<div class="imgcontainer" style="margin-top: 5vh; ">
    						<img style="width: 92%; border-radius: 58%;    margin-top: 4%;">
    					</div>
    					<div class="row justify-content-center" style="margin-bottom: 0%;">
    						<div class="col-9" style="margin-bottom: 70px;">
    							<div class="text" style="background: white;">No.{{$request['profile']['id']}} &nbsp;<strong>{{$request['profile']['name']}}&nbsp;{{$request['profile']['lastname']}}</strong>
    							</div>
    							<div class="text" style="background: white;"> Score: <strong>{{$request['score']['totalCorrect']}}/{{$request['score']['totalQuestions']}}</strong>
    							</div>
    							<div class="text" style="background: white;"> Tiempo: <strong>{{$request['time']['hour']}} hras {{$request['time']['minute']}} min</strong>
    							</div>
    						</div>
    						<div class="col-9 m-3">
    							<a href="http://oaxaca.travel" style="color: #ff6207; font-size: large; padding-bottom:15px;">www.oaxaca.travel</a>
    						</div>
                <br><br>

    					</div>
    				</div>
    			</div>
    		</div>
      </div>
    </div>
    <script src="{{asset('js/html2canvas.js')}}"></script>
    <script src="{{ asset('js/app.js') }}"></script>
  </body>
</html>
