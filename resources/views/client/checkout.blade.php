<x-template.layout title="{{ $title }}" >
  <x-organisms.navbar :path="$shop->path"/>
  <div class="container mt-3">
    <h2>Checkout</h2>
    <hr/>
  </div>
  <x-organisms.carts />
  <x-organisms.checkout-form />

    {{-- KHALTI PAYMENT BUTTON --}}
    <div class="container mt-3">
      <button id="payment-button" class="btn btn-primary">Pay with Khalti</button>
    </div>

    <x-organisms.footer :shop="$shop"/>

    {{-- Khalti Script --}}
    <script src="https://khalti.com/static/khalti-checkout.js"></script>

    {{-- Khalti Payment Script --}}
    <script>
      var config = {
          // Replace this key with your test/live public key from https://khalti.com/merchant/dashboard/
          //"publicKey": "test_public_key_dc74b4e2eb19453bb6c75e27b5cf87b9",
          "publicKey": "672e6bd7b93347988e8c71145283c12c",
          "productIdentity": "1234567890", // can be order ID or product ID
          "productName": "E-Commerce Order",
          "productUrl": "{{ url()->current() }}",
          "paymentPreference": ["KHALTI", "EBANKING", "MOBILE_BANKING", "CONNECT_IPS", "SCT"],

          eventHandler: {
              onSuccess(payload) {
                  // Handle payment success here (e.g., send payload.token to backend for verification)
                  console.log(payload);
                  alert("Payment Successful! Verifying...");
                  
                  // Send the token to your Laravel backend using fetch or axios
                  fetch("{{ route('khalti.verify') }}", {
                      method: "POST",
                      headers: {
                          "Content-Type": "application/json",
                          "X-CSRF-TOKEN": "{{ csrf_token() }}"
                      },
                      body: JSON.stringify({ token: payload.token, amount: payload.amount })
                  })
                  .then(response => response.json())
                  .then(data => {
                      if(data.success) {
                          alert("Payment Verified!");
                          // Redirect or show confirmation
                      } else {
                          alert("Payment Verification Failed!");
                      }
                  });
              },
              onError(error) {
                  console.log(error);
                  alert("Payment Error");
              },
              onClose() {
                  console.log('Widget is closing');
              }
          }
      };

      var checkout = new KhaltiCheckout(config);
      var btn = document.getElementById("payment-button");
      btn.onclick = function () {
          // Minimum amount is 10 (i.e., 1 paisa), multiply actual price by 100
          checkout.show({ amount: 1000 }); // Example: Rs.10.00 = 1000 paisa
      }
    </script>
</x-template.layout>

