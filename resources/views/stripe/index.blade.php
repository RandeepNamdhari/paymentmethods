<!DOCTYPE html>
<html>
<head>
	<script src="https://js.stripe.com/v3/"></script>

	<style type="text/css">

		.m-0
		{
			margin: 0px;
		}
		.p-0
		{
			padding: 0px;
		}

		.heading
		{
			color: #b99662;
			padding: 5px;
		}
		.test-mode,.live-mode{
         
         
		}

		.w-50
		{
			width: 50%;
		}
		.w-25{
			width: 25%;
		}
		h3{
			width: 100%;
		}

		.row{
			display: flex;
			width: 100%;
			text-align: center;
		}

		.main-row
		{
			width: 100%;
			background:lightgray;
			padding: 15px;
			text-align: center;
			margin: auto;
			justify-content: space-around;
			flex-wrap: wrap;
		}

		.config-form
		{
			
		}
		.form-element
		{
			display: flex;
			justify-content: space-between;
			width: 80%;
			margin-top: 10px;

		}

		.value-input
		{
			width:70%;
			height: 25px;
		}

		.card-button
		{
			justify-content: end;
		}

		.p-inputs
		{
			display: flex;
			justify-content: space-between;
			height: 35px;
			width: 70%;
		}
    .hide
		{
       display: none;
		}


		


	</style>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Stripe Payments</title>
	
</head>
<body class="m-0 p-0">

<h1 class="heading m-0">Stipe Payments</h1>

<div class="row main-row">



	<div class="config-form">

		<div class="row"><h3>Try Stripe Payment Intent API with testing account.</h3></div>

		<div class="form-element">
			
		</div>

	

		<div class="form-element">
			<label class="w-25">Enter Amount<span style="color:red;padding: 2px;">*</span></label>
			<input type="text" id="payableAmount" class="value-input" name="payable_amount" placeholder="" />
		</div>

			<div class="form-element stripe hide">
			<label class="w-25">Enter Your Own Stripe Secret Key</label>
			<input type="text" class="value-input" name="stripe_key" id="stripeKey" />
		</div>

		<div class="form-element stripe hide">
			<label class="w-25">Enter Your Own Stripe Publishable Key</label>
			<input type="text" class="value-input" name="stripe_publishable_key" id="stripe_publishable_key" />
		</div>

		<div class="form-element" style="justify-content: end;">

		<!-- 	<label class="w-25">Use Your Own Stipe Credentials</label>
			<p class="p-inputs"><input style="height:30px;width:30px;" type="checkbox" onclick="showStipeInputs()" name="my_credentials" /> -->
		
			<input type="submit" class="" name="payable_amount"  placeholder="" onclick="doIndent()" value="Pay By Card" />

			<p>
		</div>

		
		

	</div>

		<div class="config-form">

			<div class="row"><h3>Card Details</h3></div>

			<div class="hide" id="loader">Please wait...</div>

		<div class="test-mode hide" id="test-mode">

		<form id="payment-form">
  <div id="payment-element">
    <!-- Elements will create form elements here -->
  </div>
  <button id="submit" style="width: 100%;margin-top:10px;">Submit</button>
  <div id="error-message">
    <!-- Display error message to your customers here -->
  </div>
</form>


		
	</div>


		
		

	</div>



	</div>

<div class="row main-row" style="background: lightcyan;">

	<h3>Stripe Response </h3><p style="text-align: center;width: 100%;">Webhook response take upto 20 seconds to come please don't refresh the page.</p>

	<div class="live-mode">

		<pre>
		<code id="webhookResponse" class="prettyprint">

   </code>

		</pre>


		
	</div>
	
</div>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" 
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" 
        crossorigin="anonymous"></script>


<script type="text/javascript">
	!function(){var e='/* Syntax highlighting for JSON objects */ .json-editor-blackbord {   background: #1c2833;   color: #fff;   font-size: 13px;   font-family: Menlo,Monaco,Consolas,"Courier New",monospace; } @media screen and (min-width: 1600px) {   .json-editor-blackbord {     font-size: 14px;   } }  ul.json-dict, ol.json-array {   list-style-type: none;   margin: 0 0 0 1px;   border-left: 1px dotted #525252;   padding-left: 2em; } .json-string {   /*color: #0B7500;*/   /*color: #BCCB86;*/   color: #0ad161; } .json-literal {   /*color: #1A01CC;*/   /*font-weight: bold;*/   color: #ff8c00; } .json-url {   color: #1e90ff; } .json-property {   color: #4fdee5;   line-height: 160%;   font-weight: 500; }  /* Toggle button */ a.json-toggle {   position: relative;   color: inherit;   text-decoration: none;   cursor: pointer; } a.json-toggle:focus {   outline: none; } a.json-toggle:before {   color: #aaa;   content: "\\25BC"; /* down arrow */   position: absolute;   display: inline-block;   width: 1em;   left: -1em; } a.json-toggle.collapsed:before {   transform: rotate(-90deg); /* Use rotated down arrow, prevents right arrow appearing smaller than down arrow in some browsers */   -ms-transform: rotate(-90deg);   -webkit-transform: rotate(-90deg); }   /* Collapsable placeholder links */ a.json-placeholder {   color: #aaa;   padding: 0 1em;   text-decoration: none; } a.json-placeholder:hover {   text-decoration: underline; }',o=function(e){var o=document.getElementsByTagName("head")[0],t=document.createElement("style");if(o.appendChild(t),t.styleSheet)t.styleSheet.disabled||(t.styleSheet.cssText=e);else try{t.innerHTML=e}catch(n){t.innerText=e}};o(e)}(),function(e){function o(e){return e instanceof Object&&Object.keys(e).length>0}function t(e){var o=/^(ftp|http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/;return o.test(e)}function n(e,s){var l="";if("string"==typeof e)e=e.replace(/&/g,"&amp;").replace(/</g,"&lt;").replace(/>/g,"&gt;"),l+=t(e)?'<a href="'+e+'" class="json-string json-url">"'+e+'"</a>':'<span class="json-string">"'+e+'"</span>';else if("number"==typeof e)l+='<span class="json-literal json-literal-number">'+e+"</span>";else if("boolean"==typeof e)l+='<span class="json-literal json-literal-boolean">'+e+"</span>";else if(null===e)l+='<span class="json-literal json-literal-null">null</span>';else if(e instanceof Array)if(e.length>0){l+='[<ol class="json-array">';for(var r=0;r<e.length;++r)l+="<li>",o(e[r])&&(l+='<a href class="json-toggle"></a>'),l+=n(e[r],s),r<e.length-1&&(l+=","),l+="</li>";l+="</ol>]"}else l+="[]";else if("object"==typeof e){var a=Object.keys(e).length;if(a>0){l+='{<ul class="json-dict">';for(var i in e)if(e.hasOwnProperty(i)){l+="<li>";var c=s.withQuotes?'<span class="json-string json-property">"'+i+'"</span>':'<span class="json-property">'+i+"</span>";l+=o(e[i])?'<a href class="json-toggle">'+c+"</a>":c,l+=": "+n(e[i],s),--a>0&&(l+=","),l+="</li>"}l+="</ul>}"}else l+="{}"}return l}e.fn.jsonViewer=function(t,s){return s=s||{},this.each(function(){var l=n(t,s);o(t)&&(l='<a href class="json-toggle"></a>'+l),e(this).html(l),e(this).off("click"),e(this).on("click","a.json-toggle",function(){var o=e(this).toggleClass("collapsed").siblings("ul.json-dict, ol.json-array");if(o.toggle(),o.is(":visible"))o.siblings(".json-placeholder").remove();else{var t=o.children("li").length,n=t+(t>1?" items":" item");o.after('<a href class="json-placeholder">'+n+"</a>")}return!1}),e(this).on("click","a.json-placeholder",function(){return e(this).siblings("a.json-toggle").click(),!1}),1==s.collapsed&&e(this).find("a.json-toggle").click()})}}(jQuery),function(e){function o(e){var o={'"':'\\"',"\\":"\\\\","\b":"\\b","\f":"\\f","\n":"\\n","\r":"\\r","	":"\\t"};return e.replace(/["\\\b\f\n\r\t]/g,function(e){return o[e]})}function t(e){if("string"==typeof e)o(e);else if("object"==typeof e)for(var n in e)e[n]=t(e[n]);else if(Array.isArray(e))for(var s=0;s<e.length;s++)e[s]=t(e[s]);return e}function n(o,t,n){n=n||{},n.editable!==!1&&(n.editable=!0),this.$container=e(o),this.options=n,this.load(t)}n.prototype={constructor:n,load:function(e){e=t(e),this.$container.jsonViewer(t(e),{collapsed:this.options.defaultCollapsed,withQuotes:!0}).addClass("json-editor-blackbord").attr("contenteditable",!!this.options.editable)},get:function(){try{return e(".collapsed").click(),JSON.parse(this.$container.text())}catch(o){alert("Wrong JSON Format: "+o)}}},window.JsonEditor=n}(jQuery);

	// get JSON 
function getJson() {
  try {
    return JSON.parse($('#json-input').val());
  } catch (ex) {
    alert('Wrong JSON Format: ' + ex);
  }
}

// initialize


// enable translate button
$('#translate').on('click', function () {
  editor.load(getJson());
});


	function showStipeInputs()
	{
		 var stripeInputs=document.getElementsByClassName('stripe');


  
		for(var i=0;i < stripeInputs.length;i++)
		{
			
			  if(stripeInputs[i].classList.contains('hide'))
			  {
			  	stripeInputs[i].classList.remove('hide');
			  }
			  else
			  {
			  	stripeInputs[i].classList.add('hide');
			  }
		}
	}

	var stripeKeyValue='pk_test_Rjn8VBCm6ozrHgyU4GKMQRpT001gxuV5ik';

	var stripeKeyInput=document.getElementById('stripeKey');

  var amountInput=document.getElementById('payableAmount');

  var loader=document.getElementById('loader');

	async function doIndent()
	{
       loader.classList.remove('hide');

        var data = new FormData();
       
        data.append('stripeClient',stripeKeyInput.value);
        data.append('amount',amountInput.value);


	      var response=await fetch("{{route('stripe.payment.indent')}}",
                               {
                                    method: "POST",
                                    headers:  {
    
                                                'X-CSRF-TOKEN':'{{csrf_token()}}',

                                              },
                                 
                                    body: data
                                })

            response.json().then(function(data){

	                                             if(data.status)
	                                             {
                                                  
		                                              showStripeForm(data.client_secret);


	                                             }
	                                             else
	                                             {
		                                   
		                                              alert(data.message);

	                                             }

                                               });
	}

	function showStripeForm(client_secret)
	{

	if(stripeKeyInput.length)
	{
		stripeKeyValue=stripeKeyInput.value;
	}

	const stripe = Stripe(stripeKeyValue);

	const options = {
  clientSecret: client_secret,
  // Fully customizable with appearance API.
  appearance: {/*...*/},
};

// Set up Stripe.js and Elements to use in checkout form, passing the client secret obtained in step 2
const elements = stripe.elements(options);

// Create and mount the Payment Element
const paymentElement = elements.create('payment');
paymentElement.mount('#payment-element');




const form = document.getElementById('payment-form');

setTimeout(function(){
       loader.classList.add('hide');

	document.getElementById('test-mode').classList.remove('hide');
},3000)

form.addEventListener('submit', async (event) => {
  event.preventDefault();




  const {paymentIntent,error} = await stripe.confirmPayment({
    //`Elements` instance that was used to create the Payment Element
    elements,
    redirect:'if_required',
    confirmParams: {

      return_url: '{{route("stripe.success")}}',
    },
  });



  if (error) {
    // This point will only be reached if there is an immediate error when
    // confirming the payment. Show error to your customer (e.g., payment
    // details incomplete)
    alert(error.message)
  } else {

  	if(paymentIntent.status==="succeeded")
  {
  	document.getElementById('test-mode').classList.add('hide');
  	$('#payment-element').html('');
  	document.getElementById('payableAmount').value='';
  	 //console.log(client_secret);
  	 setTimeout(function(){

  	 showResponseFromWebhook(client_secret);


  	 },15000);


  }
    // Your customer will be redirected to your `return_url`. For some payment
    // methods like iDEAL, your customer will be redirected to an intermediate
    // site first to authorize the payment, then redirected to the `return_url`.
  }
});


}

async function showResponseFromWebhook(client_secret)
	{
      

        var data = new FormData();
       
        data.append('client_secret',client_secret);
      


	      var response=await fetch("{{route('stripe.payment.webhook.response')}}",
                               {
                                    method: "POST",
                                    headers:  {
    
                                                'X-CSRF-TOKEN':'{{csrf_token()}}',

                                              },
                                 
                                    body: data
                                })

            response.json().then(function(data){

	                                             if(data.status)
	                                             {
                                                  
		                                              

		                                              //document.getElementById('webhookResponse').innerHTML=data.response;
		                                              var editor = new JsonEditor('#webhookResponse', data.response);
		                                            //  editor.load(data.response);


	                                             }
	                                             else
	                                             {
		                                   
		                                              alert(data.message);

	                                             }

                                               });
	}




</script>

</body>
</html>