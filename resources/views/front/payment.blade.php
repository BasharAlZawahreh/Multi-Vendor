<x-front-layout>
    <section class="trending-product section" style="margin-top: 12px;">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div id="payment-message" style="display: none"></div>
                    <form id="payment-form" action="" method="post">
                        <div class="section-title" id="payment-element">
                            <button type="submit" class="btn">
                                <span id="button-text">
                                    Pay Now
                                </span>
                                <span id="spinner" style="display: hidden">processing...</span>
                                </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    @push('scripts')
        <script src="https://js.stripe.com/v3/"></script>

        <script>
            // This is your test publishable API key.
            const stripe = Stripe("{{ config('services.stripe.key') }}");

            // The items the customer wants to buy
            const items = [{
                id: "xl-tshirt"
            }];

            let elements;

            initialize();

            document
                .querySelector("#payment-form")
                .addEventListener("submit", handleSubmit);

            // Fetches a payment intent and captures the client secret
            async function initialize() {
                const {
                    clientSecret
                } = await fetch("{{ route('stripe.intent', $order->id) }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json"
                    },
                    body: JSON.stringify({
                        "_token": "{{ csrf_token() }}",
                    }),
                }).then((r) => r.json());

                elements = stripe.elements({
                    clientSecret
                });

                const paymentElement = elements.create("payment");
                paymentElement.mount("#payment-element");
            }

            async function handleSubmit(e) {
                e.preventDefault();
                setLoading(true);

                const {
                    error
                } = await stripe.confirmPayment({
                    elements,
                    confirmParams: {
                        // Make sure to change this to your payment completion page
                        return_url: "{{ route('stripe.success',$order->id) }}",
                    },
                });

                // This point will only be reached if there is an immediate error when
                // confirming the payment. Otherwise, your customer will be redirected to
                // your `return_url`. For some payment methods like iDEAL, your customer will
                // be redirected to an intermediate site first to authorize the payment, then
                // redirected to the `return_url`.
                if (error.type === "card_error" || error.type === "validation_error") {
                    showMessage(error.message);
                } else {
                    showMessage("An unexpected error occurred.");
                }

                setLoading(false);
            }


            // ------- UI helpers -------

            function showMessage(messageText) {
                const messageContainer = document.querySelector("#payment-message");

                messageContainer.style.display="block";
                messageContainer.textContent = messageText;

                setTimeout(function() {
                    messageContainer.style.display="none";
                    messageText.textContent = "";
                }, 4000);
            }

            // Show a spinner on payment submission
            function setLoading(isLoading) {
                if (isLoading) {
                    // Disable the button and show a spinner
                    document.querySelector("#submit").disabled = true;
                    document.querySelector("#spinner").style.display="inline";
                    document.querySelector("#button-text").style.display="none";
                } else {
                    document.querySelector("#submit").disabled = false;
                    document.querySelector("#spinner").style.display="inline";
                    document.querySelector("#button-text").style.display="none";
                }
            }
        </script>
    </x-front-layout>
@endpush
