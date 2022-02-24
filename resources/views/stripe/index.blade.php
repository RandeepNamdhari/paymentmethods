<!DOCTYPE html>
<html>
<head>

	<script src="https://js.stripe.com/v3/"></script>
	<link rel=stylesheet       href=https://cdn.jsdelivr.net/npm/pretty-print-json@1.2/dist/pretty-print-json.css>

@laravelPWA
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

<h1 class="heading m-0">Stripe Payments</h1>

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

			<div class="row" style="flex-direction: column;"><h3>Card Details</h3>
				<p>For testing cards please visit <a target="_blank" href="https://stripe.com/docs/testing">stripe testing</a></p></div>

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

			<pre id="webhookResponse" class="prettyprint">

   </pre>

		


		
	</div>
	
</div>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" 
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" 
        crossorigin="anonymous"></script>

        <script src=https://cdn.jsdelivr.net/npm/pretty-print-json@1.2/dist/pretty-print-json.min.js></script>


<script type="text/javascript">


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
                                                  $('#webhookResponse').html('');
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
                                                  console.log(data.response);
		                                              

		                                             $('#webhookResponse').html(prettyPrintJson.toHtml(JSON.parse(data.response)));

		                                            


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