<?php

namespace Database\Seeders;

use App\Enums\PartnerType;
use App\Models\ContactMessage;
use App\Models\Fabric;
use App\Models\FabricCategory;
use App\Models\HeroSlide;
use App\Models\Inquiry;
use App\Models\InquiryItem;
use App\Models\Page;
use App\Models\Partner;
use App\Models\Post;
use App\Models\Setting;
use App\Models\Stat;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DemoContentSeeder extends Seeder
{
    /**
     * @var array<string, array{0: string, 1: string}>
     */
    private array $palettes = [];

    /**
     * Seed demo content so the site is fully populated out of the box.
     */
    public function run(): void
    {
        if (Fabric::query()->exists()) {
            return;
        }

        $this->seedSettings();
        $this->seedStats();
        $this->seedHeroSlides();
        $this->seedPages();
        $categories = $this->seedCategories();
        $fabrics = $this->seedFabrics($categories);
        $this->seedPartners();
        $this->seedPosts();
        $this->seedInquiries($fabrics);
    }

    private function seedSettings(): void
    {
        Setting::setMany([
            'company_name' => 'SHAOXING BN TEX',
            'tagline' => 'Global fabric sourcing, simplified.',
            'contact_email' => 'info@bntex.com',
            'notification_email' => 'info@bntex.com',
            'phone' => '+86 575 8412 0000',
            'whatsapp' => '+86 138 0000 0000',
            'wechat_id' => 'BNTEX-Sourcing',
            'address' => 'Room 1208, China Textile City, Keqiao District, Shaoxing, Zhejiang, China',
            'home_intro_heading' => 'A trading partner, not just a supplier',
            'home_intro_text' => 'SHAOXING BN TEX is a China-based textile trading company located in Keqiao, the largest fabric distribution hub in the world. We source, inspect and deliver woven and knitted fabrics for garment makers and brands across more than 30 countries — acting as your eyes, ears and quality team on the ground.',
            'meta_description' => 'SHAOXING BN TEX is a China-based textile trading company sourcing cotton, T/C, CVC, linen, viscose, polyester, denim and corduroy fabrics for buyers worldwide.',
            'footer_note' => 'China-based fabric trading company serving garment makers and brands worldwide.',
        ]);
    }

    private function seedStats(): void
    {
        $stats = [
            ['label' => 'Years of Experience', 'value' => '12', 'suffix' => '+'],
            ['label' => 'Countries Served', 'value' => '30', 'suffix' => '+'],
            ['label' => 'Partner Mills', 'value' => '80', 'suffix' => '+'],
            ['label' => 'Yards Shipped Annually', 'value' => '8', 'suffix' => 'M+'],
        ];

        foreach ($stats as $index => $stat) {
            Stat::query()->create([...$stat, 'sort_order' => $index]);
        }
    }

    private function seedHeroSlides(): void
    {
        $slides = [
            [
                'title' => 'Your Fabric Sourcing Partner in China',
                'subtitle' => 'From the world\'s largest textile hub to your production line — quality fabrics sourced, inspected and delivered.',
                'button_text' => 'View Fabric Catalogue',
                'button_url' => '/fabrics',
                'palette' => ['#1f2933', '#3e4c59'],
            ],
            [
                'title' => 'Hundreds of Fabrics. One Consolidated Inquiry.',
                'subtitle' => 'Browse the catalogue, add fabrics to your inquiry basket and receive a single consolidated quotation.',
                'button_text' => 'How It Works',
                'button_url' => '/sourcing',
                'palette' => ['#27323f', '#4a5f7d'],
            ],
            [
                'title' => 'Quality Inspected at the Mill',
                'subtitle' => 'Every order is checked before it ships — construction, shade, hand feel and packing.',
                'button_text' => 'Our Sourcing Process',
                'button_url' => '/sourcing',
                'palette' => ['#2d2a26', '#57534e'],
            ],
        ];

        foreach ($slides as $index => $slide) {
            $path = 'hero/slide-'.($index + 1).'.svg';
            Storage::disk('public')->put($path, $this->heroSvg($slide['palette'][0], $slide['palette'][1]));

            HeroSlide::query()->create([
                'title' => $slide['title'],
                'subtitle' => $slide['subtitle'],
                'image' => $path,
                'button_text' => $slide['button_text'],
                'button_url' => $slide['button_url'],
                'sort_order' => $index,
            ]);
        }
    }

    private function seedPages(): void
    {
        $pages = [
            [
                'slug' => 'about',
                'title' => 'About Us',
                'intro' => 'A China-based textile trading company connecting international buyers with the right mills since 2014.',
                'body' => <<<'HTML'
<h2>Who We Are</h2>
<p>SHAOXING BN TEX is a textile trading company headquartered in Keqiao, Shaoxing — home to China Textile City, the largest fabric marketplace in the world. For over a decade we have helped garment manufacturers, wholesalers and brands source woven and knitted fabrics with confidence.</p>
<h2>Our Mission</h2>
<p>Sourcing fabric from China should not require a local office, a translator and months of trial and error. Our mission is to make professional fabric sourcing accessible to buyers of every size — with honest specifications, inspected quality and dependable lead times.</p>
<h2>Global Presence</h2>
<p>We currently serve customers in more than 30 countries across South Asia, the Middle East, Europe, Africa and the Americas. Wherever your production is based, we work in your time zone and communicate in clear English through email, WhatsApp and WeChat.</p>
<h2>Why Buyers Stay With Us</h2>
<p>We are traders, but we behave like your purchasing office: we compare mills, negotiate prices, arrange lab dips and proceed to bulk only after approval. Our long-standing mill relationships mean priority production slots and better pricing than a buyer can usually achieve alone.</p>
HTML,
                'meta_description' => 'Learn about SHAOXING BN TEX — a Keqiao-based fabric trading company serving international garment makers and brands since 2014.',
            ],
            [
                'slug' => 'sourcing',
                'title' => 'Sourcing & Services',
                'intro' => 'More than a middleman — a complete sourcing service from fabric development to loading the container.',
                'body' => <<<'HTML'
<h2>1. Understand Your Requirement</h2>
<p>Send us your specification, a photo, or even a physical swatch. We identify the construction, composition and finish, and confirm the target price and quantity with you before approaching mills.</p>
<h2>2. Source From the Right Mill</h2>
<p>Keqiao gives us access to thousands of weaving and dyeing mills. We shortlist the mills that genuinely specialise in your fabric — not simply the nearest agent — and collect counter samples for your approval.</p>
<h2>3. Sample and Approve</h2>
<p>Lab dips, strike-offs and sample yardage are couriered to you for approval. Nothing goes to bulk until you sign off shade, hand feel and quality.</p>
<h2>4. Inspect Before Shipment</h2>
<p>Our team inspects bulk production at the mill: width, weight, shade continuity, defect points and packing. You receive an inspection report with photos before the goods leave the factory.</p>
<h2>5. Deliver On Time</h2>
<p>We handle export documentation, booking and loading, and keep you informed at every step — FOB, CIF or door-to-door according to your preference.</p>
HTML,
                'meta_description' => 'How SHAOXING BN TEX sources, samples, inspects and delivers fabrics for international buyers — a complete sourcing service.',
            ],
            [
                'slug' => 'sustainability',
                'title' => 'Sustainability & Quality',
                'intro' => 'Responsible sourcing and consistent quality are not optional extras — they are how we keep buyers for a decade.',
                'body' => <<<'HTML'
<h2>Quality System</h2>
<p>Every bulk order is inspected against the approved sample using the 4-point system. We check construction, GSM, width, shade continuity and packing before shipment, and share a photographic inspection report with every delivery.</p>
<h2>Responsible Sourcing</h2>
<p>We prioritise mills holding OEKO-TEX Standard 100, GOTS, GRS or BCI certification, and can supply certified organic cotton, recycled polyester and sustainably produced viscose on request.</p>
<h2>Transparency</h2>
<p>Buyers receive true fabric specifications — actual composition, actual weight, actual width. If a mill cannot meet the promised specification, we tell you before you order, not after.</p>
HTML,
                'meta_description' => 'SHAOXING BN TEX quality inspection system and sustainable fabric sourcing — OEKO-TEX, GOTS, GRS and BCI certified options.',
            ],
        ];

        foreach ($pages as $page) {
            Page::query()->create([
                ...$page,
                'meta_title' => $page['title'].' — SHAOXING BN TEX',
            ]);
        }
    }

    /**
     * @return array<string, FabricCategory>
     */
    private function seedCategories(): array
    {
        $definitions = [
            ['name' => '100% Cotton', 'description' => 'Poplin, twill, canvas, voile and sateen woven from pure cotton yarns.', 'palette' => ['#d8cfc2', '#c9beae']],
            ['name' => 'T/C Blends', 'description' => 'Durable polyester-cotton blends for shirting, workwear and linings.', 'palette' => ['#b9c4c9', '#a7b3b9']],
            ['name' => 'CVC', 'description' => 'Cotton-rich polyester blends combining comfort with easy care.', 'palette' => ['#c5ccc0', '#b3bcac']],
            ['name' => 'Linen & Blends', 'description' => 'Pure linen and linen-viscose/cotton blends with natural texture.', 'palette' => ['#d6c8a8', '#c8b892']],
            ['name' => 'Viscose & Rayon', 'description' => 'Fluid, breathable viscose challis, twill and crepe for womenswear.', 'palette' => ['#cbb8c6', '#bba4b6']],
            ['name' => 'Polyester', 'description' => 'Microfiber, taffeta, satin and recycled polyester qualities.', 'palette' => ['#b0bcd0', '#9dabc2']],
            ['name' => 'Denim', 'description' => 'Rigid and stretch denim from 6oz shirting weight to 14oz heavy.', 'palette' => ['#5b708c', '#4a5f7d']],
            ['name' => 'Corduroy', 'description' => 'Baby cord to wide wale, rigid and stretch corduroy qualities.', 'palette' => ['#a98e6f', '#97795a']],
            ['name' => 'Spandex & Stretch', 'description' => 'Cotton, nylon and polyester stretch fabrics with 2-way or 4-way spandex.', 'palette' => ['#9fb4ab', '#8ba399']],
        ];

        $categories = [];

        foreach ($definitions as $index => $definition) {
            $category = FabricCategory::query()->create([
                'name' => $definition['name'],
                'slug' => Str::slug($definition['name']),
                'description' => $definition['description'],
                'sort_order' => $index,
            ]);

            $this->palettes[$definition['name']] = $definition['palette'];
            $categories[$definition['name']] = $category;
        }

        return $categories;
    }

    /**
     * @param  array<string, FabricCategory>  $categories
     * @return Collection<int, Fabric>
     */
    private function seedFabrics(array $categories)
    {
        $definitions = [
            '100% Cotton' => [
                ['Cotton Poplin 40s', '40x40 133x72', '100% Cotton', '57/58"', '110 GSM', 'Reactive dyed, soft finish', true],
                ['Cotton Twill 21s', '21x21 108x58', '100% Cotton', '57/58"', '190 GSM', 'Peach finish', true],
                ['Cotton Canvas 10oz', '10x10 74x44', '100% Cotton', '57/58"', '340 GSM', 'PFD / dyed', false],
                ['Cotton Voile 60s', '60x60 90x88', '100% Cotton', '57/58"', '75 GSM', 'Mercerized', false],
                ['Cotton Sateen 40s', '40x40 173x120', '100% Cotton', '57/58"', '135 GSM', 'Silky sateen finish', false],
            ],
            'T/C Blends' => [
                ['T/C Poplin 45s', '45x45 110x76', '65% Polyester 35% Cotton', '57/58"', '105 GSM', 'Easy-care shirting', true],
                ['T/C Twill Workwear', '20x16 120x60', '65% Polyester 35% Cotton', '57/58"', '245 GSM', 'Durable press', false],
                ['T/C Pocketing 96x72', '45x45 96x72', '80% Polyester 20% Cotton', '57/58"', '90 GSM', 'Plain weave, dyed', false],
            ],
            'CVC' => [
                ['CVC Poplin 50s', '50x50 144x76', '60% Cotton 40% Polyester', '57/58"', '115 GSM', 'Soft peach finish', false],
                ['CVC Twill 16s', '16x12 108x56', '60% Cotton 40% Polyester', '57/58"', '260 GSM', 'Brushed', true],
                ['CVC Oxford Shirting', '40x32 110x70', '55% Cotton 45% Polyester', '57/58"', '135 GSM', 'Oxford weave', false],
            ],
            'Linen & Blends' => [
                ['Pure Linen 14s', '14x14 52x53', '100% Linen', '57/58"', '185 GSM', 'Enzyme washed', true],
                ['Linen Viscose 55/45', '13x13 50x48', '55% Linen 45% Viscose', '57/58"', '210 GSM', 'Soft washed', false],
                ['Linen Cotton Chambray', '11x11 51x50', '55% Linen 45% Cotton', '57/58"', '230 GSM', 'Yarn dyed chambray', false],
            ],
            'Viscose & Rayon' => [
                ['Viscose Challis 30s', '30x30 68x62', '100% Viscose', '57/58"', '125 GSM', 'Print base / dyed', true],
                ['Rayon Twill 30s', '30x30 110x76', '100% Rayon', '57/58"', '160 GSM', 'Sand washed', false],
                ['Viscose Crepe', '30x30 60x58', '100% Viscose', '57/58"', '135 GSM', 'Crepe handle', false],
            ],
            'Polyester' => [
                ['Poly Peach Skin', '75D x 150D', '100% Polyester', '57/58"', '120 GSM', 'Peach skin microfiber', false],
                ['Recycled Poly Taffeta 190T', '68D x 68D', '100% Recycled Polyester', '57/58"', '65 GSM', 'Cire / PU coated on request', true],
                ['Poly Satin Charmeuse', '50D x 75D', '100% Polyester', '57/58"', '95 GSM', 'Bright satin face', false],
                ['Poly Interlock Knit', '32S/1', '100% Polyester', '63"', '180 GSM', 'Wicking finish available', false],
            ],
            'Denim' => [
                ['Rigid Denim 13.5oz', '10x10 70x50', '100% Cotton', '63"', '13.5 OZ', 'Sanforized, indigo', true],
                ['Stretch Denim 10oz', '10x16+70D 96x64', '98% Cotton 2% Spandex', '58/60"', '10 OZ', 'Indigo, mercerized', true],
                ['Light Denim Shirting 6oz', '16x16 100x84', '100% Cotton', '57/58"', '6 OZ', 'Soft washed indigo', false],
            ],
            'Corduroy' => [
                ['8 Wale Corduroy', '16x12 64x128', '100% Cotton', '57/58"', '310 GSM', 'Cut & brushed', false],
                ['14 Wale Stretch Cord', '16x12+70D 64x128', '97% Cotton 3% Spandex', '54/55"', '260 GSM', 'Stretch, washed', true],
                ['21 Wale Baby Cord', '40x40 100x180', '100% Cotton', '57/58"', '190 GSM', 'Fine baby cord', false],
            ],
            'Spandex & Stretch' => [
                ['Cotton Spandex Twill 97/3', '16x16+70D 120x60', '97% Cotton 3% Spandex', '54/55"', '240 GSM', 'Peach finish, stretch', true],
                ['Nylon Spandex 4-Way', '70D x 70D + 40D', '82% Nylon 18% Spandex', '58/60"', '190 GSM', '4-way stretch, matte', false],
                ['Poly Rayon Spandex Ponte', '150D+30S+40D', '62% Poly 33% Rayon 5% Spandex', '58/60"', '300 GSM', 'Double knit ponte', false],
            ],
        ];

        $fabrics = collect();
        $sort = 0;

        foreach ($definitions as $categoryName => $rows) {
            $category = $categories[$categoryName];
            [$base, $accent] = $this->palettes[$categoryName];

            foreach ($rows as [$name, $construction, $composition, $width, $weight, $finish, $featured]) {
                $slug = Str::slug($name);
                $path = "fabrics/{$slug}.svg";
                Storage::disk('public')->put($path, $this->fabricSvg($name, $base, $accent));

                $fabrics->push(Fabric::query()->create([
                    'category_id' => $category->id,
                    'name' => $name,
                    'slug' => $slug,
                    'image' => $path,
                    'construction' => $construction,
                    'composition' => $composition,
                    'width' => $width,
                    'weight' => $weight,
                    'finish' => $finish,
                    'colors' => 'Dyed to order — lab dips provided for approval',
                    'moq' => '1,000 m per colour',
                    'lead_time' => '25-35 days after approval',
                    'description' => "{$name} in {$composition}, {$construction}, {$width} width at {$weight}. {$finish}. Suitable for garment production with consistent bulk quality; samples and lab dips available on request.",
                    'is_featured' => $featured,
                    'sort_order' => $sort++,
                ]));
            }
        }

        return $fabrics;
    }

    private function seedPartners(): void
    {
        $buyers = [
            'NORDIC ATTIRE', 'Velora', 'UrbanThread', 'MERIDIAN', 'Cotton & Co', 'APEXWEAR',
            'Lumen Studio', 'FairForm', 'Bluecrest', 'Kastella', 'MODA VERDE', 'Northloom',
        ];

        $vendors = [
            'Keqiao Weaving Mill', 'Hangzhou Dyeing Works', 'Shaoxing Textile Group', 'Ningbo Knits',
            'Jiangsu Cotton Mill', 'Wujiang Fibre Co.', 'Qingdao Denim Works', 'Zhejiang Corduroy Mill',
        ];

        foreach ([PartnerType::Buyer->value => $buyers, PartnerType::Vendor->value => $vendors] as $type => $names) {
            foreach ($names as $index => $name) {
                $path = "partners/{$type}-".Str::slug($name).'.svg';
                Storage::disk('public')->put($path, $this->logoSvg($name));

                Partner::query()->create([
                    'type' => $type,
                    'name' => $name,
                    'logo' => $path,
                    'sort_order' => $index,
                ]);
            }
        }
    }

    private function seedPosts(): void
    {
        $posts = [
            [
                'title' => 'BN TEX to Exhibit at Intertextile Shanghai Apparel Fabrics 2026',
                'excerpt' => 'Visit our booth to see the new season collection of cotton, linen and stretch qualities, and meet the sourcing team in person.',
                'days_ago' => 6,
                'palette' => ['#4a5f7d', '#27323f'],
            ],
            [
                'title' => 'New Certified Sustainable Viscose Line Added to Our Catalogue',
                'excerpt' => 'We have added a range of FSC-certified viscose challis and crepe qualities produced with closed-loop processing.',
                'days_ago' => 21,
                'palette' => ['#8ba399', '#5f7a6e'],
            ],
            [
                'title' => 'Cotton Price Trends: What Buyers Should Expect This Season',
                'excerpt' => 'A short overview of raw cotton pricing, yarn availability and what it means for your fabric budgets over the coming quarter.',
                'days_ago' => 38,
                'palette' => ['#c9beae', '#a08d72'],
            ],
            [
                'title' => 'Inside Our Quality Inspection Process',
                'excerpt' => 'From loom to loading: how our team applies the 4-point system so problems are caught at the mill, not at your warehouse.',
                'days_ago' => 60,
                'palette' => ['#57534e', '#2d2a26'],
            ],
            [
                'title' => 'BN TEX Expands Denim Sourcing Network in Guangdong',
                'excerpt' => 'Three new partner mills bring additional capacity in stretch and heavyweight denim with faster lead times.',
                'days_ago' => 85,
                'palette' => ['#4a5f7d', '#1f2933'],
            ],
            [
                'title' => 'Meet Us at Canton Fair Phase 3',
                'excerpt' => 'Schedule a meeting with our export team during Canton Fair to review swatch books and discuss your upcoming programmes.',
                'days_ago' => 120,
                'palette' => ['#97795a', '#5c4a37'],
            ],
        ];

        foreach ($posts as $post) {
            $slug = Str::slug($post['title']);
            $path = "posts/{$slug}.svg";
            Storage::disk('public')->put($path, $this->heroSvg($post['palette'][0], $post['palette'][1]));

            Post::query()->create([
                'title' => $post['title'],
                'slug' => $slug,
                'image' => $path,
                'excerpt' => $post['excerpt'],
                'body' => '<p>'.$post['excerpt'].'</p><p>SHAOXING BN TEX works with a network of more than 80 partner mills across Zhejiang, Jiangsu and Guangdong, giving buyers access to a wide range of qualities with inspected, consistent bulk production. Our export team communicates in clear English and supports buyers through sampling, approval and shipment.</p><p>For details about this announcement, specifications, or to request swatches from the current catalogue, contact our team by email, WhatsApp or WeChat — or submit an inquiry basket directly through the website and we will respond within one working day.</p>',
                'is_published' => true,
                'published_at' => now()->subDays($post['days_ago']),
            ]);
        }
    }

    /**
     * @param  Collection<int, Fabric>  $fabrics
     */
    private function seedInquiries($fabrics): void
    {
        Inquiry::factory()
            ->count(3)
            ->create()
            ->each(function (Inquiry $inquiry) use ($fabrics) {
                foreach ($fabrics->random(random_int(2, 3)) as $fabric) {
                    InquiryItem::factory()->create([
                        'inquiry_id' => $inquiry->id,
                        'fabric_id' => $fabric->id,
                        'fabric_name' => $fabric->name,
                    ]);
                }
            });

        ContactMessage::factory()->count(2)->create();
    }

    private function fabricSvg(string $label, string $base, string $accent): string
    {
        $label = e($label);

        return <<<SVG
<svg xmlns="http://www.w3.org/2000/svg" width="800" height="600" viewBox="0 0 800 600">
  <defs>
    <pattern id="weave" width="16" height="16" patternUnits="userSpaceOnUse" patternTransform="rotate(45)">
      <rect width="16" height="16" fill="{$base}"/>
      <rect width="8" height="16" fill="{$accent}"/>
    </pattern>
  </defs>
  <rect width="800" height="600" fill="url(#weave)"/>
  <rect width="800" height="600" fill="rgba(20,20,20,0.25)"/>
  <text x="400" y="300" font-family="Georgia, 'Times New Roman', serif" font-size="36" fill="#ffffff" text-anchor="middle" dominant-baseline="middle">{$label}</text>
</svg>
SVG;
    }

    private function heroSvg(string $from, string $to): string
    {
        return <<<SVG
<svg xmlns="http://www.w3.org/2000/svg" width="1920" height="900" viewBox="0 0 1920 900">
  <defs>
    <linearGradient id="bg" x1="0" y1="0" x2="1" y2="1">
      <stop offset="0" stop-color="{$from}"/>
      <stop offset="1" stop-color="{$to}"/>
    </linearGradient>
    <pattern id="texture" width="24" height="24" patternUnits="userSpaceOnUse" patternTransform="rotate(45)">
      <rect width="24" height="24" fill="none"/>
      <rect width="12" height="24" fill="rgba(255,255,255,0.03)"/>
    </pattern>
  </defs>
  <rect width="1920" height="900" fill="url(#bg)"/>
  <rect width="1920" height="900" fill="url(#texture)"/>
</svg>
SVG;
    }

    private function logoSvg(string $name): string
    {
        $name = e($name);

        return <<<SVG
<svg xmlns="http://www.w3.org/2000/svg" width="320" height="160" viewBox="0 0 320 160">
  <rect width="320" height="160" fill="#ffffff"/>
  <rect x="10" y="10" width="300" height="140" fill="none" stroke="#e2e2e2" stroke-width="2"/>
  <text x="160" y="80" font-family="Helvetica, Arial, sans-serif" font-size="22" font-weight="bold" letter-spacing="1" fill="#41454c" text-anchor="middle" dominant-baseline="middle">{$name}</text>
</svg>
SVG;
    }
}
