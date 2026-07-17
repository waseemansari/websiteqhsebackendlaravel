ccavenu<!DOCTYPE html>
<html>
<head>
    <title>Redirecting to CCAvenue...</title>
</head>
<body>

<h3>Please wait...</h3>
<p>Redirecting you to the secure payment gateway.</p>

<form id="ccavenue-form"
      method="POST"
      action="https://secure.ccavenue.ae/transaction/transaction.do?command=initiateTransaction">

    <input type="hidden" name="encRequest" value="{{ $encrypted_data }}">
    <input type="hidden" name="access_code" value="{{ $access_code }}">

</form>

<script>
    document.getElementById('ccavenue-form').submit();
</script>

</body>
</html>