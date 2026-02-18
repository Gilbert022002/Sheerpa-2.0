<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Course;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Define categories relevant to Sheerpa platform
        $categories = [
            [
                'name' => 'Développement Web',
                'slug' => 'developpement-web',
                'description' => 'Cours de développement web : HTML, CSS, JavaScript, frameworks modernes',
                'icon' => 'code',
            ],
            [
                'name' => 'Design & UI/UX',
                'slug' => 'design-ui-ux',
                'description' => 'Cours de design graphique, UI/UX, Figma, Adobe',
                'icon' => 'palette',
            ],
            [
                'name' => 'Marketing Digital',
                'slug' => 'marketing-digital',
                'description' => 'Cours de marketing digital, SEO, réseaux sociaux, publicité en ligne',
                'icon' => 'campaign',
            ],
            [
                'name' => 'Entrepreneuriat',
                'slug' => 'entrepreneuriat',
                'description' => 'Cours pour entrepreneurs : business plan, financement, gestion',
                'icon' => 'business_center',
            ],
            [
                'name' => 'Data & IA',
                'slug' => 'data-ia',
                'description' => 'Cours de data science, machine learning, intelligence artificielle',
                'icon' => 'insights',
            ],
            [
                'name' => 'Mobile',
                'slug' => 'mobile',
                'description' => 'Cours de développement mobile : iOS, Android, Flutter, React Native',
                'icon' => 'smartphone',
            ],
            [
                'name' => 'DevOps & Cloud',
                'slug' => 'devops-cloud',
                'description' => 'Cours DevOps, cloud computing, Docker, Kubernetes, AWS',
                'icon' => 'cloud',
            ],
            [
                'name' => 'Cybersécurité',
                'slug' => 'cybersecurite',
                'description' => 'Cours de sécurité informatique, protection des données, ethical hacking',
                'icon' => 'security',
            ],
            [
                'name' => 'Soft Skills',
                'slug' => 'soft-skills',
                'description' => 'Cours de développement personnel, communication, leadership',
                'icon' => 'psychology',
            ],
            [
                'name' => 'Freelance & Carrière',
                'slug' => 'freelance-carriere',
                'description' => 'Cours pour freelances : trouver des clients, fixer ses prix, gestion',
                'icon' => 'work',
            ],
        ];

        // Create categories
        foreach ($categories as $categoryData) {
            Category::firstOrCreate(
                ['slug' => $categoryData['slug']],
                $categoryData
            );
        }

        // Migrate existing courses to categories based on their 'category' text field
        $this->migrateExistingCategories();
    }

    /**
     * Migrate existing course categories to the new category system.
     */
    private function migrateExistingCategories(): void
    {
        // Get all courses that have a category text value
        $courses = Course::whereNotNull('category')
            ->where('category', '!=', '')
            ->get();

        foreach ($courses as $course) {
            // Try to find a matching category by name (case-insensitive)
            $category = Category::whereRaw('LOWER(name) = LOWER(?)', [$course->category])->first();

            // If no exact match, try to find by slug
            if (!$category) {
                $slug = Str::slug($course->category);
                $category = Category::where('slug', $slug)->first();
            }

            // If still no match, create a new category
            if (!$category) {
                $category = Category::create([
                    'name' => $course->category,
                    'slug' => Str::slug($course->category),
                    'description' => null,
                    'icon' => 'school',
                    'is_active' => true,
                ]);
            }

            // Update the course with the category_id
            $course->update([
                'category_id' => $category->id,
            ]);
        }
    }
}
