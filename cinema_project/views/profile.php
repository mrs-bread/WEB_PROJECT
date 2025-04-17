<?php require 'partials/header.php'; ?>
<h1>Мои бронирования</h1>
<?php if(empty($bookings)): ?>
  <p>У вас нет бронирований.</p>
<?php else: ?>
  <ul>
    <?php foreach($bookings as $b): ?>
      <li><?php echo $b['title']; ?> (<?php echo $b['session_date']; ?> <?php echo $b['session_time']; ?>): место <?php echo $b['seat_number']; ?></li>
    <?php endforeach; ?>
  </ul>
<?php endif; ?>
<?php require 'partials/footer.php'; ?>