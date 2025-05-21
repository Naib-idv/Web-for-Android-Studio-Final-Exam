document.querySelector('a[href="races.php"]').addEventListener('click', function (e) {
    // Nếu bạn muốn thực hiện các thao tác trước khi điều hướng, có thể thêm các hiệu ứng ở đây
    // Ví dụ: Ẩn carousel và hiển thị loading screen

    // Sau đó, cho phép điều hướng trang bình thường
    // Không sử dụng e.preventDefault() nữa

    // Tùy chọn: Chạy các hiệu ứng trước khi chuyển hướng, nếu cần
    setTimeout(function() {
        window.location.href = "races.php"; // Điều hướng đến trang races.php
    }, 500); // Sau khi 500ms, trang sẽ chuyển hướng
});

document.addEventListener("DOMContentLoaded", function () {
    const countdownElements = document.querySelectorAll(".countdown");

    countdownElements.forEach((element) => {
        const targetDate = new Date(element.getAttribute("data-date")).getTime();

        function updateCountdown() {
            const now = new Date().getTime();
            const distance = targetDate - now;

            if (distance < 0) {
                element.innerHTML = "Racing";
                return;
            }

            const days = Math.floor(distance / (1000 * 60 * 60 * 24));
            const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((distance % (1000 * 60)) / 1000);

            element.innerHTML = `${days} days ${hours} hours ${minutes} minutes ${seconds} seconds`;

            // Cập nhật mỗi giây
            setTimeout(updateCountdown, 1000);
        }

        updateCountdown();
    });
});


function validateForm() {
    const password = document.querySelector('input[name="password"]').value;
    const confirmPassword = document.querySelector('input[name="confirm_password"]').value;

    if (password !== confirmPassword) {
        alert("Passwords do' not match.");
        return false;
    }

    return true;
}

function openJoinModal(raceID) {
    // Lấy thông tin của cuộc thi từ DOM
    var raceItem = document.getElementById('race-' + raceID);
    var raceName = raceItem.querySelector('h3').textContent;
    var raceDate = raceItem.querySelector('p').textContent;
    var raceMap = raceItem.querySelector('img').getAttribute('src');

    // Cập nhật thông tin vào modal
    document.getElementById('modalRaceName').textContent = raceName;
    document.getElementById('modalRaceDate').textContent = raceDate;
    document.getElementById('modalRaceMap').setAttribute('src', raceMap);
    document.getElementById('modalRaceID').value = raceID;

    // Hiển thị modal
    var modal = document.getElementById('raceModal');
    modal.style.display = "block";
}

// Đóng modal khi bấm vào dấu X
document.getElementById('closeModal').onclick = function() {
    var modal = document.getElementById('raceModal');
    modal.style.display = "none";
}

// Đóng modal nếu bấm ra ngoài modal
window.onclick = function(event) {
    var modal = document.getElementById('raceModal');
    if (event.target == modal) {
        modal.style.display = "none";
    }
}