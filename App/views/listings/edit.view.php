<?php 
/**
 * @var object $listing
 * @var array $errors
 */
?>
<?php loadPartial('head'); ?>
<?php loadPartial('navbar'); ?>
<?php loadPartial('topBanner'); ?>

<section class="flex justify-center">
  <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-lg mt-8">
    
    <h2 class="text-4xl text-center font-bold mb-4">Edit Job Listing</h2>

    <!-- EDIT FORM -->
    <form method="POST" action="/listings/<?= $listing->id ?>">
        <input type="hidden" name="_method" value="PUT">

      <!-- Job Info -->
      <h2 class="text-2xl font-bold mb-6 text-center text-gray-500">
        Job Info
      </h2>
      <?php if(isset($errors)) : ?>
        <?php foreach($errors as $error) : ?>
          <div class="bg-red-100 my-3 text-red-700 p-3 mb-4 rounded">
            <?= $error ?>
          </div>
        <?php endforeach; ?>
      <?php endif; ?>

      <div class="mb-4">
        <label class="block text-gray-700 font-bold mb-2">Job Title</label>
        <input type="text" name="title" placeholder="Software Engineer"
          class="border rounded w-full py-2 px-3"
          value="<?= $listing->title ?? '' ?>">
      </div>

      <div class="mb-4">
        <label class="block text-gray-700 font-bold mb-2">Job Description</label>
        <textarea name="description" rows="4"
          class="border rounded w-full py-2 px-3"
          placeholder="We are seeking a skilled software engineer..."><?= $listing->description ?? '' ?></textarea>
      </div>

      <div class="mb-4">
        <label class="block text-gray-700 font-bold mb-2">Annual Salary</label>
        <input type="number" name="salary" placeholder="90000"
          class="border rounded w-full py-2 px-3"
          value="<?= $listing->salary ?? '' ?>">
      </div>

      <div class="mb-4">
        <label class="block text-gray-700 font-bold mb-2">Requirements</label>
        <textarea name="requirements" rows="3"
          class="border rounded w-full py-2 px-3"
          placeholder="Bachelor's degree, 3+ years experience..."><?= $listing->requirements ?? '' ?></textarea>
      </div>

      <div class="mb-4">
        <label class="block text-gray-700 font-bold mb-2">Benefits</label>
        <textarea name="benefits" rows="3"
          class="border rounded w-full py-2 px-3"
          placeholder="Health insurance, 401k..."><?= $listing->benefits ?? '' ?></textarea>
      </div>

      <div class="mb-4">
        <label class="block text-gray-700 font-bold mb-2">Tags (comma separated)</label>
        <input type="text" name="tags"
          class="border rounded w-full py-2 px-3"
          placeholder="development, coding, java, python"
          value="<?= $listing->tags ?? '' ?>">
      </div>

      <!-- Company Info -->
      <h2 class="text-2xl font-bold mb-6 text-center text-gray-500">
        Company Info
      </h2>

      <div class="mb-4">
        <label class="block text-gray-700 font-bold mb-2">Company Name</label>
        <input type="text" name="company"
          class="border rounded w-full py-2 px-3"
          placeholder="Company name"
          value="<?= $listing->company ?? '' ?>">
      </div>

      <div class="mb-4">
        <label class="block text-gray-700 font-bold mb-2">Address</label>
        <input type="text" name="address"
          class="border rounded w-full py-2 px-3"
          placeholder="123 Main St"
          value="<?= $listing->address ?? '' ?>">
      </div>

      <div class="mb-4">
        <label class="block text-gray-700 font-bold mb-2">City</label>
        <input type="text" name="city"
          class="border rounded w-full py-2 px-3"
          placeholder="Chicago"
          value="<?= $listing->city ?? '' ?>">
      </div>

      <div class="mb-4">
        <label class="block text-gray-700 font-bold mb-2">State</label>
        <input type="text" name="state"
          class="border rounded w-full py-2 px-3"
          placeholder="IL"
          value="<?= $listing->state ?? '' ?>">
      </div>

      <div class="mb-4">
        <label class="block text-gray-700 font-bold mb-2">Phone</label>
        <input type="text" name="phone"
          class="border rounded w-full py-2 px-3"
          placeholder="555-555-5555"
          value="<?= $listing->phone ?? '' ?>">
      </div>

      <div class="mb-4">
        <label class="block text-gray-700 font-bold mb-2">Email</label>
        <input type="email" name="email"
          class="border rounded w-full py-2 px-3"
          placeholder="email@example.com"
          value="<?= $listing->email ?? '' ?>">
      </div>

      <!-- Buttons -->
      <div>
        <button type="submit"
          class="w-full bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded">
          Update Listing
        </button>

        <a href="/listings" class="block text-center text-gray-500 mt-4">
          Cancel
        </a>
      </div>

    </form>
  </div>
</section>

<?php loadPartial('footer'); ?>