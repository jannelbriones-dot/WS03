<?php loadPartial('head'); ?>
<?php loadPartial('navbar'); ?>

<section class="flex justify-center items-center mt-20">
  <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-md">
    <h2 class="text-4xl text-center font-bold mb-4">Register</h2>

    <!-- Display errors directly without partial -->
    <?php if (!empty($errors)) : ?>
      <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
        <strong class="font-bold">Please fix the following errors:</strong>
        <ul class="mt-2 list-disc list-inside">
          <?php foreach ($errors as $field => $error) : ?>
            <li><?= $error ?></li>
          <?php endforeach; ?>
        </ul>
      </div>
    <?php endif; ?>

    <form method="POST" action="/auth/register">
      <div class="mb-4">
        <label class="block text-gray-700 font-bold mb-2">Full Name</label>
        <input type="text" name="name"
          placeholder="Full Name"
          class="border rounded w-full py-2 px-3 <?= isset($errors['name']) ? 'border-red-500' : '' ?>"
          value="<?= isset($user) ? $user['name'] ?? '' : '' ?>" />
        <?php if (isset($errors['name'])) : ?>
          <p class="text-red-500 text-xs mt-1"><?= $errors['name'] ?></p>
        <?php endif; ?>
      </div>

      <div class="mb-4">
        <label class="block text-gray-700 font-bold mb-2">Email Address</label>
        <input type="email" name="email"
          placeholder="Email Address"
          class="border rounded w-full py-2 px-3 <?= isset($errors['email']) ? 'border-red-500' : '' ?>"
          value="<?= isset($user) ? $user['email'] ?? '' : '' ?>" />
        <?php if (isset($errors['email'])) : ?>
          <p class="text-red-500 text-xs mt-1"><?= $errors['email'] ?></p>
        <?php endif; ?>
      </div>

      <div class="mb-4">
        <label class="block text-gray-700 font-bold mb-2">City</label>
        <input type="text" name="city"
          placeholder="City"
          class="border rounded w-full py-2 px-3"
          value="<?= isset($user) ? $user['city'] ?? '' : '' ?>" />
      </div>

      <div class="mb-4">
        <label class="block text-gray-700 font-bold mb-2">State</label>
        <input type="text" name="state"
          placeholder="State"
          class="border rounded w-full py-2 px-3"
          value="<?= isset($user) ? $user['state'] ?? '' : '' ?>" />
      </div>

      <div class="mb-4">
        <label class="block text-gray-700 font-bold mb-2">Password</label>
        <input type="password" name="password"
          placeholder="Password"
          class="border rounded w-full py-2 px-3 <?= isset($errors['password']) ? 'border-red-500' : '' ?>" />
        <?php if (isset($errors['password'])) : ?>
          <p class="text-red-500 text-xs mt-1"><?= $errors['password'] ?></p>
        <?php endif; ?>
      </div>

      <div class="mb-4">
        <label class="block text-gray-700 font-bold mb-2">Confirm Password</label>
        <input type="password" name="password_confirmation"
          placeholder="Confirm Password"
          class="border rounded w-full py-2 px-3 <?= isset($errors['password_confirmation']) ? 'border-red-500' : '' ?>" />
        <?php if (isset($errors['password_confirmation'])) : ?>
          <p class="text-red-500 text-xs mt-1"><?= $errors['password_confirmation'] ?></p>
        <?php endif; ?>
      </div>

      <button type="submit"
        class="w-full bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded">
        Register
      </button>

      <p class="mt-4 text-center">
        Already have an account?
        <a href="/auth/login" class="text-green-500 hover:underline">Login</a>
      </p>
    </form>
  </div>
</section>

<?php loadPartial('footer'); ?>