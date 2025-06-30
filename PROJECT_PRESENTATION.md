# Presentasi & Panduan Fitur Utama Project Laravel

---

## 1. Autentikasi (Login & Register)

### Teori & Penjelasan
Autentikasi adalah proses untuk memastikan hanya user yang terdaftar yang bisa mengakses aplikasi. User harus register (daftar) lalu login (masuk) menggunakan email dan password.

### Step by Step
1. User buka halaman register.
2. Isi nama, email, password, lalu submit.
3. Akun berhasil dibuat, user diarahkan ke halaman login.
4. User login dengan email & password.

### Potongan Kode Register
```php
// app/Http/Controllers/AuthController.php
public function register(Request $request)
{
    $validated = $request->validate([
        'name' => 'required',
        'email' => 'required|email|unique:users',
        'password' => 'required|confirmed|min:6',
    ]);
    $user = User::create([
        'name' => $validated['name'],
        'email' => $validated['email'],
        'password' => bcrypt($validated['password']),
    ]);
    // Kirim email verifikasi
    $user->sendEmailVerificationNotification();
    return redirect()->route('login')->with('success', 'Cek email untuk verifikasi!');
}
```

---

## 2. Verifikasi Email

### Teori & Penjelasan
Verifikasi email memastikan email yang digunakan user benar-benar milik mereka. Setelah daftar, user harus klik link verifikasi yang dikirim ke email.

### Step by Step
1. Setelah register, user dapat pesan: "Cek email untuk verifikasi".
2. User buka email, klik link verifikasi.
3. Akun aktif, user bisa login dan akses fitur utama.

---

## 3. Lupa Password (Forgot Password)

### Teori & Penjelasan
Fitur ini membantu user yang lupa password agar bisa reset password lewat email.

### Step by Step
1. User klik "Lupa Password" di halaman login.
2. Masukkan email, klik submit.
3. Sistem kirim link reset password ke email user.
4. User buka email, klik link, lalu buat password baru.
5. Password berhasil diubah, user bisa login lagi.

### Potongan Kode Forgot Password
```php
// app/Http/Controllers/AuthController.php
use Illuminate\Support\Facades\Password;

public function forgotPassword(Request $request)
{
    $request->validate(['email' => 'required|email']);
    Password::sendResetLink($request->only('email'));
    return back()->with('status', 'Link reset password sudah dikirim ke email!');
}
```

---

## 4. Import Data Excel ke Database via Tinker

### Teori & Penjelasan
Fitur ini memudahkan admin untuk memasukkan data banyak sekaligus ke database, cukup dengan upload file Excel. Proses import bisa dilakukan lewat Tinker (command line Laravel).

### Step by Step
1. Siapkan file Excel (misal: `recipes.xlsx`) berisi data yang ingin diimport.
2. Simpan file Excel di folder `storage/app`.
3. Buka terminal, jalankan:
   ```
   php artisan tinker
   ```
4. Import data dengan perintah:
   ```php
   use Maatwebsite\Excel\Facades\Excel;
   use App\Imports\RecipesImport;
   Excel::import(new RecipesImport, 'storage/app/recipes.xlsx');
   ```
5. Data dari Excel sudah masuk ke database.

### Potongan Kode Import
```php
// app/Imports/RecipesImport.php
namespace App\Imports;

use App\Models\Recipe;
use Maatwebsite\Excel\Concerns\ToModel;

class RecipesImport implements ToModel
{
    public function model(array $row)
    {
        return new Recipe([
            'title' => $row[0],
            'description' => $row[1],
            // Tambahkan kolom lain sesuai kebutuhan
        ]);
    }
}
```

---

## 5. Menampilkan Data dari Database ke Frontend

### Teori & Penjelasan
Data yang sudah diimport ke database bisa langsung ditampilkan di website, sehingga user bisa melihat data terbaru.

### Step by Step
1. User buka halaman resep di website.
2. Sistem mengambil data resep dari database.
3. Data resep ditampilkan di halaman frontend (misal: daftar resep, tabel, atau card).

### Potongan Kode Controller & View
```php
// app/Http/Controllers/FrontendRecipeController.php
use App\Models\Recipe;

public function index()
{
    $recipes = Recipe::all();
    return view('frontend.recipes.index', compact('recipes'));
}
```

```blade
<!-- resources/views/frontend/recipes/index.blade.php -->
@foreach($recipes as $recipe)
    <div class="card">
        <h3>{{ $recipe->title }}</h3>
        <p>{{ $recipe->description }}</p>
    </div>
@endforeach
```

---

## 6. User Bisa Menambah Resep Sendiri

### Teori & Penjelasan
Fitur ini memungkinkan setiap user untuk menambah resep mereka sendiri ke sistem. Resep yang ditambahkan akan langsung tersimpan di database dan bisa dilihat di frontend.

### Step by Step
1. User login ke aplikasi.
2. User buka halaman tambah resep.
3. Isi form resep (judul, deskripsi, dll), lalu submit.
4. Resep tersimpan di database dan bisa langsung tampil di frontend.

### Potongan Kode Controller
```php
// app/Http/Controllers/FrontendRecipeController.php
use App\Models\Recipe;
use Illuminate\Http\Request;

public function create()
{
    return view('frontend.recipes.create');
}

public function store(Request $request)
{
    $validated = $request->validate([
        'title' => 'required',
        'description' => 'required',
        // Tambahkan validasi lain sesuai kebutuhan
    ]);
    $validated['user_id'] = auth()->id();
    Recipe::create($validated);
    return redirect()->route('frontend.recipes.index')->with('success', 'Resep berhasil ditambahkan!');
}
```

### Potongan Kode Form Blade
```blade
<!-- resources/views/frontend/recipes/create.blade.php -->
<form method="POST" action="{{ route('frontend.recipes.store') }}">
    @csrf
    <input type="text" name="title" placeholder="Judul Resep" required>
    <textarea name="description" placeholder="Deskripsi" required></textarea>
    <button type="submit">Tambah Resep</button>
</form>
```

---

## 7. User Bisa Review & Rating Resep

### Teori & Penjelasan
Fitur ini memungkinkan user memberikan review (komentar) dan rating (nilai bintang) pada resep yang ada di sistem. Review dan rating akan tersimpan di database dan bisa dilihat oleh user lain.

### Step by Step
1. User login dan buka detail resep.
2. User isi form review dan pilih rating (misal: 1-5 bintang).
3. Submit review, data tersimpan di database.
4. Review dan rating tampil di halaman detail resep.

### Potongan Kode Controller
```php
// app/Http/Controllers/FrontendReviewController.php
use App\Models\Review;
use Illuminate\Http\Request;

public function store(Request $request, $recipeId)
{
    $validated = $request->validate([
        'comment' => 'required',
        'rating' => 'required|integer|min:1|max:5',
    ]);
    $validated['user_id'] = auth()->id();
    $validated['recipe_id'] = $recipeId;
    Review::create($validated);
    return back()->with('success', 'Review berhasil ditambahkan!');
}
```

### Potongan Kode Form Review Blade
```blade
<!-- resources/views/frontend/recipes/detail_resep.blade.php -->
<form method="POST" action="{{ route('frontend.reviews.store', $recipe->id) }}">
    @csrf
    <textarea name="comment" placeholder="Tulis review..." required></textarea>
    <select name="rating" required>
        <option value="">Pilih rating</option>
        @for($i=1; $i<=5; $i++)
            <option value="{{ $i }}">{{ $i }} Bintang</option>
        @endfor
    </select>
    <button type="submit">Kirim Review</button>
</form>
```

### Menampilkan Review & Rating di Detail Resep
```blade
<!-- resources/views/frontend/recipes/detail_resep.blade.php -->
@foreach($recipe->reviews as $review)
    <div class="review">
        <strong>{{ $review->user->name }}</strong> -
        <span>{{ $review->rating }} Bintang</span>
        <p>{{ $review->comment }}</p>
    </div>
@endforeach
```

---

## Alur Sederhana

1. Admin siapkan & upload file Excel
2. Admin import data via Tinker
3. Data masuk ke database
4. User lihat data di website
5. User bisa tambah resep sendiri
6. User bisa review & memberi rating pada resep

---

## Kesimpulan

- User bisa register, login, dan reset password dengan mudah & aman.
- Admin bisa input data banyak sekaligus lewat Excel via Tinker.
- Data yang diupload langsung bisa dilihat user di website.
- User bisa menambah resep sendiri ke sistem.
- User bisa memberikan review dan rating pada resep.
- Semua proses mudah, cepat, dan efisien, serta mendorong interaksi antar pengguna.

---

**Siap untuk demo atau tanya jawab!**

Jika ingin contoh file Excel, kode migration, atau penjelasan lebih detail, silakan minta! 