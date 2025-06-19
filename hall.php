<?php
$conn = new mysqli("localhost", "root", "", "user_auth");

// Fetch movie ID and showtime from the URL
$movie_id = isset($_GET['mid']) ? $_GET['mid'] : null;
$showtime = isset($_GET['showtime']) ? $_GET['showtime'] : null;

if (!$movie_id || !$showtime) {
    die("Invalid movie selection.");
}

// Fetch movie details
$movie = $conn->query("SELECT * FROM movies WHERE mid = '$movie_id'")->fetch_assoc();
if (!$movie) {
    die("Movie not found.");
}

// Fetch booked seats for this movie and showtime
$result = $conn->query("SELECT seat_number FROM bookings WHERE mid = '$movie_id' AND showtime = '$showtime'");
$bookedSeats = [];
while ($row = $result->fetch_assoc()) {
    $bookedSeats[] = $row['seat_number'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movie Seat Booking</title>
    <script src="https://khalti.com/static/khalti-checkout.js"></script>
    <style>
        body { font-family: Arial, sans-serif; text-align: center; background: #0b132b; color: white; }
        .screen { background: #d32f2f; height: 30px; width: 80%; margin: 20px auto; text-align: center; color: white; font-weight: bold; padding: 5px; }
        .seats { display: grid; grid-template-columns: repeat(20, 50px); gap: 10px; justify-content: center; margin: 20px; }
        .seat { width: 50px; height: 50px; background: #444; border-radius: 5px; cursor: pointer; display: flex; align-items: center; justify-content: center; color: white; }
        .seat.sold { background: red; cursor: not-allowed; }
        .seat.selected { background: green; }
        .button { padding: 10px 20px; background: green; color: white; border: none; cursor: pointer; margin-top: 10px; }
        .disabled { background: grey; cursor: not-allowed; }
        #total { margin-top: 10px; font-size: 18px; }
    </style>
</head>
<body>

    <h2>Booking for: <?= htmlspecialchars($movie['title']) ?> (Showtime: <?= htmlspecialchars($showtime) ?>)</h2>
    <div class="screen">SCREEN</div>
    <div class="seats">
        <?php
        foreach (range('A', 'J') as $row) {  
            for ($col = 1; $col <= 20; $col++) {  
                $seat = $row . $col;
                $class = in_array($seat, $bookedSeats) ? 'seat sold' : 'seat';
                echo "<div class='$class' data-seat='$seat'>$seat</div>";
            }
        }
        ?>
    </div>

    <p id="total">Total: Rs. 0.00</p>
    <button id="proceedBtn" class="button disabled" onclick="proceedPayment()" disabled>Proceed</button>

    <script>
        let selectedSeats = [];
        const seatPrice = 350;
        document.querySelectorAll(".seat:not(.sold)").forEach(seat => {
            seat.addEventListener("click", function() {
                if (this.classList.contains("selected")) {
                    this.classList.remove("selected");
                    selectedSeats = selectedSeats.filter(s => s !== this.dataset.seat);
                } else {
                    this.classList.add("selected");
                    selectedSeats.push(this.dataset.seat);
                }
                updateTotal();
            });
        });

        function updateTotal() {
            let total = selectedSeats.length * seatPrice;
            document.getElementById("total").innerText = `Total: Rs. ${total.toFixed(2)}`;
            let proceedBtn = document.getElementById("proceedBtn");
            if (selectedSeats.length > 0) {
                proceedBtn.classList.remove("disabled");
                proceedBtn.removeAttribute("disabled");
            } else {
                proceedBtn.classList.add("disabled");
                proceedBtn.setAttribute("disabled", "true");
            }
        }

        function proceedPayment() {
            let totalAmount = selectedSeats.length * seatPrice * 100; // Khalti needs amount in paisa
            let config = {
                publicKey: "YOUR_KHALTI_PUBLIC_KEY",
                productIdentity: "Movie_Ticket",
                productName: "<?= htmlspecialchars($movie['title']) ?>",
                productUrl: "http://yourwebsite.com",
                eventHandler: {
                    onSuccess(payload) {
                        fetch("confirm_booking.php", {
                            method: "POST",
                            headers: { "Content-Type": "application/json" },
                            body: JSON.stringify({ 
                                seats: selectedSeats, 
                                payment: payload,
                                mid: "<?= $movie_id ?>",
                                showtime: "<?= htmlspecialchars($showtime) ?>"
                            })
                        }).then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                alert("Payment Successful! Confirmation sent to email.");
                                location.reload();
                            } else {
                                alert("Booking failed. Try again.");
                            }
                        });
                    },
                    onError(error) { alert("Payment failed!"); }
                }
            };
            let checkout = new KhaltiCheckout(config);
            checkout.show({ amount: totalAmount });
        }
    </script>

</body>
</html>
