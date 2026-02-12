<?php
session_start();

if (!isset($_SESSION['user'])) {
  header('Location: login.php');
  exit;
}

$dataFile = __DIR__ . '/admin_data.json';
if (!file_exists($dataFile)) {
		file_put_contents($dataFile, json_encode([]));
}

$items = json_decode(file_get_contents($dataFile), true) ?: [];
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		$action = isset($_POST['action']) ? $_POST['action'] : '';

		if ($action === 'add') {
				$title = trim($_POST['title'] ?? '');
				$content = trim($_POST['content'] ?? '');
				if ($title !== '') {
						$items[] = [
								'id' => uniqid(),
								'title' => $title,
								'content' => $content,
								'created_at' => date('c'),
						];
						file_put_contents($dataFile, json_encode($items, JSON_PRETTY_PRINT));
						$message = 'Item added.';
				} else {
						$message = 'Title is required.';
				}
		}

		if ($action === 'delete') {
				$id = $_POST['id'] ?? '';
				if ($id !== '') {
						$items = array_values(array_filter($items, function($it) use ($id) {
								return ($it['id'] ?? '') !== $id;
						}));
						file_put_contents($dataFile, json_encode($items, JSON_PRETTY_PRINT));
						$message = 'Item deleted.';
				}
		}

    header('Location: dashboard.php');
    exit;
}
?>

<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Admin Dashboard</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 text-gray-900">
  <div class="max-w-6xl mx-auto px-4 py-8">
    <div class="flex items-center justify-between mb-6">
      <h1 class="text-2xl font-bold">Admin Dashboard</h1>
      <div class="text-sm">
        Logged in as <span class="font-medium"><?php echo htmlspecialchars($_SESSION['user']); ?></span>
        — <a href="logout.php" class="text-indigo-600">Logout</a>
      </div>
    </div>

    <?php if (!empty($items)): ?>
      <div class="overflow-x-auto bg-white rounded-lg shadow">
        <table class="min-w-full divide-y divide-gray-200">
          <thead class="bg-gray-50">
            <tr>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Title</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Content</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Created</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Action</th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-200">
          <?php foreach ($items as $it): ?>
            <tr>
              <td class="px-6 py-4 whitespace-nowrap"><?php echo htmlspecialchars($it['title']); ?></td>
              <td class="px-6 py-4 text-sm text-gray-700"><?php echo nl2br(htmlspecialchars($it['content'])); ?></td>
              <td class="px-6 py-4 text-sm text-gray-500"><?php echo htmlspecialchars($it['created_at']); ?></td>
              <td class="px-6 py-4">
                <form method="post" action="dashboard.php" class="inline">
                  <input type="hidden" name="action" value="delete">
                  <input type="hidden" name="id" value="<?php echo htmlspecialchars($it['id']); ?>">
                  <button type="submit" class="text-sm text-red-600 hover:underline">Delete</button>
                </form>
              </td>
            </tr>
          <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    <?php else: ?>
      <div class="bg-white p-6 rounded-lg shadow">No items yet.</div>
    <?php endif; ?>

    <div class="mt-8 bg-white p-6 rounded-lg shadow">
      <h2 class="text-lg font-semibold mb-3">Add Admin Item</h2>
      <form method="post" action="dashboard.php" class="space-y-4">
        <input type="hidden" name="action" value="add">
        <div>
          <label class="block text-sm font-medium text-gray-700">Title</label>
          <input type="text" name="title" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700">Content</label>
          <textarea name="content" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"></textarea>
        </div>
        <div>
          <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-md">Add Item</button>
        </div>
      </form>
    </div>
  </div>
</body>
</html>
