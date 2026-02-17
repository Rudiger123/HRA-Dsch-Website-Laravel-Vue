# 👨‍💻 Guide du Développeur

**Date:** 17 février 2026  
**Niveau:** Intermédiaire+

---

## 📋 Table des matières

1. [Architecture](##architecture)
2. [Conventions de code](##conventions-de-code)
3. [Structure des dossiers](##structure-des-dossiers)
4. [Créer un nouveau modèle](##créer-un-nouveau-modèle)
5. [Créer une nouvelle feature](##créer-une-nouvelle-feature)
6. [Tests](##tests)
7. [Debugging](##debugging)
8. [Performance](##performance)
9. [SEO](##seo)
10. [Déploiement](##déploiement)

---

## Architecture

### MVC Pattern (Laravel)

```
Requête HTTP
    ↓
Router (routes/web.php or routes/api.php)
    ↓
Middleware (auth, permissions, etc.)
    ↓
Controller (logique métier)
    ↓
Model (accès données)
    ↓
Database
    ↓
View (Inertia component)
    ↓
Response JSON/HTML
```

### Inertia.js Architecture

```
Frontend (Vue 3 components)
    ↓
Inertia Link/Router
    ↓
Laravel Route
    ↓
Controller (Inertia::render)
    ↓
Response (JSON + Vue component)
    ↓
Client-side rendering
```

### Stack complète

```
┌─────────────────────── FRONTEND ───────────────────────┐
│  Vue 3 Components (resources/js/Pages, Components)      │
│  ├─ Inertia Link/Router navigation                      │
│  ├─ TailwindCSS styling                                 │
│  └─ Lucide icons                                        │
├────────────────────────────────────────────────────────┤
│          HTTP Request/Response via Inertia              │
├────────────────────────────────────────────────────────┤
│  Laravel 12 (Backend)                                   │
│  ├─ Routes (routes/web.php)                             │
│  ├─ Controllers (app/Http/Controllers)                  │
│  ├─ Models (app/Models)                                 │
│  ├─ Middleware (app/Http/Middleware)                    │
│  └─ Requests (app/Http/Requests)                        │
├───────────────────────────────────────────────────────┤
│  Database (SQLite/MySQL)                                │
│  ├─ Migrations (database/migrations)                    │
│  ├─ Seeders (database/seeders)                          │
│  └─ Factories (database/factories)                      │
└────────────────────────────────────────────────────────┘
```

---

## Conventions de code

### Nommage

**Classes:**
```php
class UserController      // Singular + Controller
class CreateUserRequest   // Verb + Noun + Request
class User               // Singular
class Subscriber         // Noun
```

**Méthodes:**
```php
public function store()        // Resource verbes: store, show, edit, update, destroy
public function toggleActive() // Action spécifique
private function validateData() // Private helpers
```

**Variables:**
```php
$user = User::find($id);       // Singular object
$users = User::all();          // Plural collection
$isActive = true;              // Boolean avec is/has prefix
$createdAt = now();            // DateTime avec At suffix
```

**Routes:**
```
GET    /admin/users           // List
GET    /admin/users/create    // Create form
POST   /admin/users           // Store
GET    /admin/users/{id}/edit // Edit form
PUT    /admin/users/{id}      // Update
DELETE /admin/users/{id}      // Delete
```

### Code Style

**PSR-12 (Laravel standard):**

```php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of users.
     * 
     * @return \Inertia\Response
     */
    public function index()
    {
        $users = User::paginate(15);
        
        return Inertia::render('Admin/Users/Index', [
            'users' => $users,
        ]);
    }

    /**
     * Store a newly created user.
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email|unique:users',
            'name' => 'required|string|max:100',
        ]);
        
        User::create($validated);
        
        return redirect()->route('admin.users.index')
            ->with('success', 'User created');
    }
}
```

**Règles:**
- ✅ 4 espaces indentation
- ✅ Max 120 caractères par ligne
- ✅ Docblocks pour public methods
- ✅ Type hints pour parameters et return
- ✅ Trait use statements groupés
- ✅ Const/static avant properties

### Mutations du modèle

```php
class User extends Authenticatable
{
    // Fillable: whitelist pour mass assignment
    protected $fillable = ['name', 'email', 'password'];
    
    // Hidden: exclure de JSON
    protected $hidden = ['password', 'remember_token'];
    
    // Casts: type casting automatique
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'is_active' => 'boolean',
    ];
    
    // Accessors: getter customs
    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }
}
```

---

## Structure des dossiers

### Backend

```
app/
├── Console/
│   └── Commands/                 # Commandes Artisan custom
├── Http/
│   ├── Controllers/
│   │   ├── Api/                  # API controllers
│   │   ├── Admin/                # Admin controllers
│   │   ├── Auth/                 # Auth controllers
│   │   └── Controller.php        # Base controller
│   ├── Middleware/
│   │   ├── Authenticate.php
│   │   └── HandleInertiaRequests.php
│   └── Requests/                 # Form requests (validation)
├── Models/
│   ├── User.php
│   ├── Service.php
│   ├── Medecin.php
│   └── ...
├── Providers/
│   └── AppServiceProvider.php
├── Mail/                         # Mailable classes
│   ├── PasswordResetMail.php
│   └── ...
└── Traits/
    └── HasSEO.php               # Traits réutilisables

config/
├── app.php                       # App config
├── auth.php                      # Auth config
├── database.php                  # Database config
├── mail.php                      # Mail config
├── permission.php                # Spatie Permissions
└── ...

database/
├── migrations/                   # Schema changes
├── seeders/                      # Test data
└── factories/                    # Model factories

routes/
├── web.php                       # Web routes (auth)
├── api.php                       # API routes (public)
└── console.php                   # Artisan commands

storage/
├── app/
│   └── public/                   # Uploaded files
├── logs/
│   └── laravel.log              # Application logs
└── framework/                    # Laravel cache
```

### Frontend

```
resources/
├── css/
│   └── app.css                   # Tailwind imports
├── js/
│   ├── app.js                    # App entry point
│   ├── Layouts/
│   │   ├── AdminLayout.vue       # Admin layout
│   │   └── PublicLayout.vue      # Public layout
│   ├── Pages/
│   │   ├── Admin/
│   │   │   ├── Dashboard.vue
│   │   │   ├── Services/
│   │   │   │   ├── Index.vue
│   │   │   │   ├── Create.vue
│   │   │   │   └── Edit.vue
│   │   │   └── ...
│   │   └── Auth/
│   │       └── Login.vue
│   ├── Components/
│   │   ├── Forms/                # Form components
│   │   ├── Tables/               # Table components
│   │   ├── Modals/               # Modal components
│   │   └── UI/                   # UI components
│   └── Composables/              # Reusable logic
├── views/                        # Blade templates (emails, etc)
│   ├── emails/
│   │   └── auth/
│   │       └── reset-password.blade.php
│   └── app.blade.php             # Root template
└── images/                       # Static images
```

---

## Créer un nouveau modèle

### Exemple complet: Création d'un modèle Blog

#### 1. Générer migration

```bash
php artisan make:migration create_blog_posts_table --create=blog_posts
```

**Fichier:** `database/migrations/YYYY_MM_DD_xxxxxx_create_blog_posts_table.php`

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('blog_posts', function (Blueprint $table) {
            $table->id();
            $table->string('title', 200);
            $table->string('slug', 200)->unique();
            $table->text('content');
            $table->string('image')->nullable();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->boolean('published')->default(false);
            $table->timestamp('published_at')->nullable();
            $table->integer('views')->default(0);
            $table->timestamps();
            
            // Index pour recherche
            $table->index('published');
            $table->index('published_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('blog_posts');
    }
};
```

#### 2. Créer le modèle

```bash
php artisan make:model BlogPost
```

**Fichier:** `app/Models/BlogPost.php`

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class BlogPost extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'content',
        'image',
        'user_id',
        'published',
        'published_at',
    ];

    protected $casts = [
        'published' => 'boolean',
        'published_at' => 'datetime',
        'views' => 'integer',
    ];

    // Auto-generate slug
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($post) {
            if (empty($post->slug)) {
                $post->slug = Str::slug($post->title);
            }
        });
    }

    // Relations
    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Scopes
    public function scopePublished($query)
    {
        return $query->where('published', true)
                     ->whereNotNull('published_at')
                     ->orderBy('published_at', 'desc');
    }

    // Accessors
    public function getUrlAttribute()
    {
        return route('blog.show', $this->slug);
    }
}
```

#### 3. Créer Factory (pour tests)

```bash
php artisan make:factory BlogPostFactory
```

**Fichier:** `database/factories/BlogPostFactory.php`

```php
<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class BlogPostFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(5),
            'slug' => $this->faker->slug(),
            'content' => $this->faker->paragraphs(5, true),
            'image' => 'https://via.placeholder.com/400x300',
            'user_id' => 1,
            'published' => $this->faker->boolean(80),
            'published_at' => $this->faker->dateTime(),
            'views' => $this->faker->numberBetween(0, 1000),
        ];
    }
}
```

#### 4. Migration et test

```bash
# Exécuter migration
php artisan migrate

# Test dans tinker
php artisan tinker
>>> BlogPost::factory(10)->create()
>>> BlogPost::published()->get()
```

---

## Créer une nouvelle feature

### Exemple: API endpoint pour liker un post

#### Étape 1: Migration pour la table likes

```bash
php artisan make:migration create_blog_post_likes_table
```

```php
Schema::create('blog_post_likes', function (Blueprint $table) {
    $table->id();
    $table->foreignId('blog_post_id')->constrained('blog_posts')->onDelete('cascade');
    $table->ipAddress();
    $table->timestamps();
    
    $table->unique(['blog_post_id', 'ip_address']);
});
```

#### Étape 2: Migration relation modèle

```bash
php artisan make:model BlogPostLike
```

```php
class BlogPostLike extends Model
{
    use HasFactory;
    
    protected $fillable = ['blog_post_id', 'ip_address'];
}
```

Ajouter relation dans BlogPost:

```php
public function likes()
{
    return $this->hasMany(BlogPostLike::class);
}

public function likeCount()
{
    return $this->likes()->count();
}
```

#### Étape 3: Controller API

**Fichier:** `app/Http/Controllers/Api/BlogPostLikeController.php`

```php
<?php

namespace App\Http\Controllers\Api;

use App\Models\BlogPost;
use Illuminate\Http\Request;

class BlogPostLikeController extends Controller
{
    public function toggle(BlogPost $blogPost, Request $request)
    {
        $ip = $request->ip();
        
        $like = BlogPost::where('blog_post_id', $blogPost->id)
            ->where('ip_address', $ip)
            ->first();
        
        if ($like) {
            $like->delete();
            $liked = false;
        } else {
            BlogPostLike::create([
                'blog_post_id' => $blogPost->id,
                'ip_address' => $ip,
            ]);
            $liked = true;
        }
        
        return response()->json([
            'liked' => $liked,
            'count' => $blogPost->likes()->count(),
        ]);
    }
}
```

#### Étape 4: Route API

**Fichier:** `routes/api.php`

```php
Route::post('/blog-posts/{blogPost}/like', [BlogPostLikeController::class, 'toggle']);
```

#### Étape 5: Composant Vue

**Fichier:** `resources/js/Components/BlogPostLike.vue`

```vue
<template>
  <div class="flex items-center gap-2">
    <button
      @click="toggleLike"
      :class="[
        liked ? 'text-red-500' : 'text-gray-400',
        'hover:text-red-500 transition-colors'
      ]"
    >
      <HeartIcon :size="24" :fill="liked ? 'currentColor' : 'none'" />
    </button>
    <span class="text-gray-600">{{ likeCount }}</span>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { HeartIcon } from 'lucide-vue-next'

const props = defineProps({
  postId: Number,
  initialLikes: Number,
})

const liked = ref(false)
const likeCount = ref(props.initialLikes)

const toggleLike = async () => {
  try {
    const response = await fetch(`/api/blog-posts/${props.postId}/like`, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-Token': document.querySelector('meta[name="csrf-token"]').content,
      },
    })
    
    const data = await response.json()
    liked.value = data.liked
    likeCount.value = data.count
  } catch (error) {
    console.error('Error:', error)
  }
}
</script>
```

#### Étape 6: Tests

**Fichier:** `tests/Feature/BlogPostLikeTest.php`

```php
<?php

namespace Tests\Feature;

use App\Models\BlogPost;
use Tests\TestCase;

class BlogPostLikeTest extends TestCase
{
    public function test_can_like_post()
    {
        $post = BlogPost::factory()->create();
        
        $response = $this->post("/api/blog-posts/{$post->id}/like");
        
        $response->assertSuccessful();
        $response->assertJson([
            'liked' => true,
            'count' => 1,
        ]);
    }

    public function test_can_unlike_post()
    {
        $post = BlogPost::factory()->create();
        $post->likes()->create(['ip_address' => '127.0.0.1']);
        
        $response = $this->post("/api/blog-posts/{$post->id}/like");
        
        $response->assertJson([
            'liked' => false,
            'count' => 0,
        ]);
    }
}
```

---

## Tests

### Philosophie des tests

- **Unit tests:** Logique isolée (services, helpers)
- **Feature tests:** Workflows complets (API, Routes)
- **Coverage:** Viser 80%+

### Exécuter tests

```bash
# Tous les tests
php artisan test

# Test spécifique
php artisan test tests/Feature/BlogPostTest.php

# Avec coverage
php artisan test --coverage

# Watcher mode
php artisan test --watch
```

### Exemple de test feature

```php
<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class AuthTest extends TestCase
{
    public function test_can_login_with_valid_credentials()
    {
        $user = User::factory()->create([
            'email' => 'admin@test.local',
            'password' => 'password123',
        ]);
        
        $response = $this->post('/admin/login', [
            'email' => 'admin@test.local',
            'password' => 'password123',
        ]);
        
        $response->assertRedirect('/admin/dashboard');
        $this->assertAuthenticatedAs($user);
    }

    public function test_cannot_login_with_invalid_credentials()
    {
        $response = $this->post('/admin/login', [
            'email' => 'invalid@test.local',
            'password' => 'wrong',
        ]);
        
        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }
}
```

---

## Debugging

### Tinker (REPL interactif)

```bash
php artisan tinker

# Exemples
>>> User::first()
>>> User::factory(10)->create()
>>> User::where('active', true)->get()
>>> $user = User::find(1)
>>> $user->update(['email' => 'new@example.com'])
>>> DB::table('users')->get()
```

### Logging

```php
// Écrire dans logs
\Log::info('Message info');
\Log::warning('Message warning');
\Log::error('Message error');

// Avec contexte
\Log::debug('User login', ['user_id' => $user->id, 'ip' => $request->ip()]);

// Voir logs
tail -f storage/logs/laravel.log
```

### Debugging Controllers

**Avec dd() - dump & die:**

```php
public function index()
{
    $users = User::all();
    dd($users);  // Affiche et arrête
    
    return Inertia::render('Users', ['users' => $users]);
}
```

**Avec dump - affiche sans arrêter:**

```php
dump($users);
\Log::dump($users);
```

### Laravel Debugbar (optionnel)

```bash
composer require barryvdh/laravel-debugbar --dev
```

Affiche queries, logs, performance dans une barre à chaque page.

### XDebug (VSCode)

1. Installer PHP XDebug
2. Configuration `.vscode/launch.json`
3. Ajouter breakpoints
4. Exécuter avec debugger

---

## Performance

### Query Optimization

**N+1 Problem:**

```php
// ❌ Mauvais (N+1 queries)
$users = User::all();
foreach ($users as $user) {
    echo $user->posts()->count();  // Requête par user
}

// ✅ Bon (Eager loading)
$users = User::with('posts')->get();  // 1 requête
foreach ($users as $user) {
    echo $user->posts->count();  // Données déjà chargées
}
```

**Lazy Eager Loading:**

```php
// Charger après récupération
User::all()->load('posts', 'comments');
```

### Pagination

```php
// Au lieu de all()
$users = User::paginate(15);  // 15 par page

// En API
$users = User::paginate($request->input('per_page', 15));
```

### Indexing

```php
// Bonjour migration
$table->index('email');
$table->index(['status', 'created_at']);
$table->unique('slug');
```

### Caching

```php
// Cache requête
$users = cache()->remember('users.active', 3600, function() {
    return User::where('active', true)->get();
});

// Invalider
cache()->forget('users.active');
```

### Monitoring Performance

```bash
# Vérifier lenteur queries
php artisan tinker
>>> DB::listen(function($query) { var_dump($query->time . 'ms: ' . $query->sql); })
>>> User::with('posts')->get()
```

---

## SEO

### Dans les models

**Trait:** `app/Traits/HasSEO.php`

```php
trait HasSEO
{
    public function seoTags()
    {
        return [
            'title' => $this->meta_title ?? $this->title,
            'description' => $this->meta_description ?? str()->limit($this->content, 160),
            'keywords' => $this->meta_keywords ?? null,
            'canonical' => route('show', $this->slug),
            'og:title' => $this->title,
            'og:description' => $this->excerpt,
            'og:image' => $this->og_image ?? $this->image,
            'og:url' => route('show', $this->slug),
        ];
    }
}
```

### Dans les controllers

```php
use Artesaos\SEOTools\Facades\SEOMeta;

public function show(BlogPost $post)
{
    SEOMeta::setTitle($post->title)
        ->setDescription($post->excerpt)
        ->setCanonical(route('blog.show', $post))
        ->addMeta('article:published_time', $post->published_at->toAtomString());
    
    OpenGraph::setTitle($post->title)
        ->setDescription($post->excerpt)
        ->setUrl(route('blog.show', $post))
        ->addImage($post->image);
    
    return Inertia::render('Blog/Show', [
        'post' => $post,
    ]);
}
```

### Sitemap

```bash
php artisan sitemap:generate
```

Génère `public/sitemap.xml` automatiquement.

---

## Déploiement

### Version control

```bash
# Commit réguliers
git add .
git commit -m "feat: add blog likes feature"

# Tags pour versions
git tag -a v1.0.0 -m "Release v1.0.0"
git push origin v1.0.0
```

### CI/CD (GitHub Actions) - Optionnel

**Fichier:** `.github/workflows/test.yml`

```yaml
name: Tests

on: [push, pull_request]

jobs:
  test:
    runs-on: ubuntu-latest
    services:
      mysql:
        image: mysql:8.0

    steps:
      - uses: actions/checkout@v3
      - uses: php-actions/composer@v6
      - run: php artisan test
```

### Pre-deploy checklist

```bash
# Stash changes
git status --clean

# Run tests
php artisan test

# Build frontend
npm run build

# Migrate (peut prendre du temps)
php artisan migrate --force

# Cache
php artisan config:cache
php artisan route:cache

# Health check
curl https://hra-dschang.cm/health
```

---

## Documentation et commentaires

### PHPDoc

```php
/**
 * Store a new blog post.
 * 
 * @param  \App\Http\Requests\StoreBlogPostRequest  $request
 * @return \Illuminate\Http\RedirectResponse
 * @throws \Illuminate\Validation\ValidationException
 */
public function store(StoreBlogPostRequest $request): RedirectResponse
{
    // ...
}
```

### Inline comments

```php
// Utiliser pour code complexe
// ❌ Mauvais - décrit ce que le code fait
$users = User::where('active', true)->get();  // Get active users

// ✅ Bon - explique pourquoi
// Filter to active users as only they can place orders
$eligible_users = User::where('active', true)->get();
```

---

## Ressources utiles

- [Laravel Documentation](https://laravel.com/docs)
- [Vue 3 Documentation](https://vuejs.org/)
- [Inertia.js](https://inertiajs.com/)
- [Tailwind CSS](https://tailwindcss.com/)
- [Spatie Packages](https://spatie.be/open-source)

---

**Questions?** Voir documentation complète ou contactez admin@hra-dschang.cm
