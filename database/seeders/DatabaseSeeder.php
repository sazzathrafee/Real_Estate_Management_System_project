<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\PropertyCategory;
use App\Models\Property;
use App\Models\VisitRequest;
use App\Models\Favorite;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create admin user
        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'phone' => '0123456789',
            'address' => 'Admin Address',
            'role' => 'admin',
        ]);

        User::factory()->create([
            'name' => 'Seller User',
            'email' => 'seller@example.com',
            'password' => bcrypt('password'),
            'phone' => '0123456790',
            'address' => 'Seller Address',
            'role' => 'seller',
        ]);

        User::factory()->create([
            'name' => 'Buyer User',
            'email' => 'buyer@example.com',
            'password' => bcrypt('password'),
            'phone' => '0123456791',
            'address' => 'Buyer Address',
            'role' => 'buyer',
        ]);

        User::factory(5)->seller()->create();
        User::factory(10)->buyer()->create();

        $sellerIds = User::where('role', 'seller')->pluck('id')->toArray();

        $categories = [];
        $categoryData = [
            ['name' => 'Apartment', 'desc' => 'Modern apartment units in residential buildings'],
            ['name' => 'Duplex', 'desc' => 'Two-floor residential units with separate entrances'],
            ['name' => 'Villa', 'desc' => 'Luxury standalone villas with premium amenities'],
            ['name' => 'Residential House', 'desc' => 'Independent houses for family living'],
            ['name' => 'Commercial Office', 'desc' => 'Office spaces for businesses and startups'],
            ['name' => 'Residential Plot', 'desc' => 'Vacant land plots for building homes'],
        ];

        foreach ($categoryData as $cat) {
            $categories[] = PropertyCategory::create([
                'category_name' => $cat['name'],
                'description' => $cat['desc'],
            ]);
        }

        $catMap = [];
        foreach ($categories as $c) {
            $catMap[$c->category_name] = $c->id;
        }

        $properties = [
            // ===== DHAKA (10 properties) =====
            [
                'title' => 'Luxury 3-Bedroom Apartment in Gulshan',
                'category' => 'Apartment',
                'description' => 'A stunning 3-bedroom apartment located in the heart of Gulshan, Dhaka\'s most prestigious residential area. This fully furnished unit features modern interiors with premium fittings, a spacious living room, modern kitchen with built-in appliances, and three well-appointed bedrooms with attached bathrooms. The apartment offers panoramic city views from the balcony, dedicated parking space, 24/7 security, generator backup, and access to a rooftop garden. Ideal for expatriates and professionals seeking a comfortable urban lifestyle in a prime location with nearby shopping malls, fine dining restaurants, and international schools.',
                'division' => 'Dhaka',
                'city' => 'Dhaka',
                'location' => 'Road 12, Gulshan Avenue, Dhaka 1212',
                'price' => 25000000,
                'bedrooms' => 3,
                'bathrooms' => 3,
                'area_size' => 1650,
                'garage' => 1,
                'property_type' => 'sale',
                'latitude' => 23.7925,
                'longitude' => 90.4078,
                'image' => 'properties/property1.jpg',
            ],
            [
                'title' => 'Elegant Villa in Banani',
                'category' => 'Villa',
                'description' => 'Beautiful standalone villa situated in the exclusive Banani area of Dhaka. This two-story residence boasts 4 spacious bedrooms, a grand living and dining area, modern kitchen, and a private garden. The villa features high ceilings, marble flooring throughout, imported sanitary ware, and central air conditioning. Located on a quiet tree-lined street yet minutes away from Banani\'s commercial hub, this property offers the perfect blend of tranquility and convenience. Additional highlights include a rooftop terrace, servant quarters, and parking for two cars.',
                'division' => 'Dhaka',
                'city' => 'Dhaka',
                'location' => 'Road 7, Banani, Dhaka 1213',
                'price' => 45000000,
                'bedrooms' => 4,
                'bathrooms' => 4,
                'area_size' => 3200,
                'garage' => 2,
                'property_type' => 'sale',
                'latitude' => 23.7936,
                'longitude' => 90.4043,
                'image' => 'properties/property2.jpg',
            ],
            [
                'title' => 'Independent House in Dhanmondi',
                'category' => 'Residential House',
                'description' => 'A charming independent house located in the tranquil Dhanmondi residential area. This well-maintained property features 4 bedrooms, a spacious living room, separate dining area, modern kitchen, and a beautiful roof terrace. The house receives abundant natural light and cross ventilation thanks to its thoughtful design. Located just steps away from Dhanmondi Lake, residents can enjoy morning walks and recreational activities. The neighborhood is known for its educational institutions, hospitals, and shopping centers making it ideal for families.',
                'division' => 'Dhaka',
                'city' => 'Dhaka',
                'location' => 'Road 4, Dhanmondi, Dhaka 1205',
                'price' => 35000000,
                'bedrooms' => 4,
                'bathrooms' => 3,
                'area_size' => 2500,
                'garage' => 1,
                'property_type' => 'sale',
                'latitude' => 23.7465,
                'longitude' => 90.3760,
                'image' => 'properties/property3.jpg',
            ],
            [
                'title' => 'Modern 2-Bedroom Apartment in Uttara',
                'category' => 'Apartment',
                'description' => 'Contemporary 2-bedroom apartment located in Sector 4 of Uttara, one of Dhaka\'s most planned and well-organized neighborhoods. The apartment features a bright and airy living space with modern finishes, modular kitchen, and two comfortable bedrooms with attached bathrooms. Residents enjoy access to a gym, swimming pool, children\'s play area, and landscaped gardens within the complex. With excellent road connectivity to the airport and downtown, this property is perfect for young professionals and small families looking for a convenient urban lifestyle.',
                'division' => 'Dhaka',
                'city' => 'Dhaka',
                'location' => 'Sector 4, Road 12, Uttara, Dhaka 1230',
                'price' => 15000000,
                'bedrooms' => 2,
                'bathrooms' => 2,
                'area_size' => 1200,
                'garage' => 1,
                'property_type' => 'sale',
                'latitude' => 23.8759,
                'longitude' => 90.3795,
                'image' => 'properties/property4.jpg',
            ],
            [
                'title' => 'Spacious Duplex in Bashundhara R/A',
                'category' => 'Duplex',
                'description' => 'Impressive duplex apartment in the prestigious Bashundhara Residential Area. This expansive property spans two floors connected by an elegant internal staircase. The lower level features a grand living room, formal dining area, modern kitchen, and guest bedroom. The upper floor houses three spacious bedrooms with attached bathrooms and a family lounge. High-end finishes include Italian marble flooring, imported light fixtures, and premium kitchen fittings. The compound offers 24/7 security, underground parking, and a community park within walking distance.',
                'division' => 'Dhaka',
                'city' => 'Dhaka',
                'location' => 'Block C, Bashundhara R/A, Dhaka 1229',
                'price' => 38000000,
                'bedrooms' => 4,
                'bathrooms' => 4,
                'area_size' => 2800,
                'garage' => 2,
                'property_type' => 'sale',
                'latitude' => 23.8143,
                'longitude' => 90.4321,
                'image' => 'properties/property5.jpg',
            ],
            [
                'title' => 'Family House in Mirpur',
                'category' => 'Residential House',
                'description' => 'Well-constructed family house located in the heart of Mirpur, Dhaka. This 3-bedroom property offers comfortable living spaces with a generous living room, separate dining area, and a modern kitchen with ample storage. The house features tiled flooring, aluminum windows, and security grills throughout. The rooftop provides excellent outdoor space for gardening or family gatherings. Situated in a quiet residential lane close to Mirpur 10, residents have easy access to shopping centers, restaurants, schools, and the Mirpur Botanical Garden.',
                'division' => 'Dhaka',
                'city' => 'Dhaka',
                'location' => 'Mirpur 10, Road 5, Block A, Dhaka 1216',
                'price' => 18000000,
                'bedrooms' => 3,
                'bathrooms' => 2,
                'area_size' => 1800,
                'garage' => 1,
                'property_type' => 'sale',
                'latitude' => 23.8050,
                'longitude' => 90.3680,
                'image' => 'properties/property6.jpg',
            ],
            [
                'title' => 'Cozy Apartment in Mohammadpur',
                'category' => 'Apartment',
                'description' => 'Charming 2-bedroom apartment in Mohammadpur, a well-established residential area of Dhaka. This mid-floor unit features a bright living room, compact modern kitchen, and two well-sized bedrooms with built-in wardrobes. The apartment is in a well-maintained building with elevator access, backup generator, and security guard. Mohammadpur offers excellent community living with numerous schools, hospitals, markets, and the famous Mohammadpur Town Hall grounds nearby. A perfect starter home for newly married couples or small families.',
                'division' => 'Dhaka',
                'city' => 'Dhaka',
                'location' => 'Mohammadpur, Dhaka 1207',
                'price' => 12000000,
                'bedrooms' => 2,
                'bathrooms' => 2,
                'area_size' => 1000,
                'garage' => 0,
                'property_type' => 'sale',
                'latitude' => 23.7650,
                'longitude' => 90.3580,
                'image' => 'properties/property7.jpg',
            ],
            [
                'title' => 'Residential Plot in Badda',
                'category' => 'Residential Plot',
                'description' => 'Prime residential plot available in the rapidly developing Badda area of Dhaka. This 5 katha plot is ideally situated in a quiet residential neighborhood with excellent road connectivity to Gulshan, Banani, and the city center. The plot is level, properly surveyed, and comes with all necessary utility connections available at the roadside. Badda has seen significant appreciation in property values and offers a balanced mix of established homes and new developments. Ideal for building a custom home or as a long-term investment in Dhaka\'s growing real estate market.',
                'division' => 'Dhaka',
                'city' => 'Dhaka',
                'location' => 'Badda Link Road, Badda, Dhaka 1212',
                'price' => 8500000,
                'bedrooms' => 0,
                'bathrooms' => 0,
                'area_size' => 3600,
                'garage' => 0,
                'property_type' => 'sale',
                'latitude' => 23.7870,
                'longitude' => 90.4250,
                'image' => 'properties/property8.jpg',
            ],
            [
                'title' => 'Commercial Office Space in Gulshan',
                'category' => 'Commercial Office',
                'description' => 'Premium commercial office space located in a high-rise building on Gulshan Avenue, Dhaka\'s premier business district. This well-designed office suite offers approximately 1500 sqft of flexible workspace with a reception area, two private cabins, open-plan workstations, a meeting room, and pantry. The building features modern facilities including high-speed elevators, backup generator, underground parking, and 24/7 security. Located in the heart of Gulshan with easy access to banks, embassies, hotels, and restaurants. Perfect for corporate offices, consulting firms, or startup headquarters.',
                'division' => 'Dhaka',
                'city' => 'Dhaka',
                'location' => 'Gulshan Avenue, Dhaka 1212',
                'price' => 55000000,
                'bedrooms' => 0,
                'bathrooms' => 2,
                'area_size' => 1500,
                'garage' => 1,
                'property_type' => 'sale',
                'latitude' => 23.7910,
                'longitude' => 90.4100,
                'image' => 'properties/property9.jpg',
            ],
            [
                'title' => 'Luxury Villa in Uttara Sector 18',
                'category' => 'Villa',
                'description' => 'Spectacular luxury villa located in the prestigious Sector 18 of Uttara, Dhaka. This magnificent 5-bedroom residence sits on a generous plot and offers unparalleled living space with a grand entrance hall, formal living and dining rooms, family lounge, and a state-of-the-art kitchen. The first floor houses all bedrooms with en-suite bathrooms and walk-in closets. Outdoor features include a landscaped garden, private swimming pool, barbecue area, and covered parking for three cars. The property represents the pinnacle of residential luxury in Dhaka.',
                'division' => 'Dhaka',
                'city' => 'Dhaka',
                'location' => 'Sector 18, Uttara, Dhaka 1230',
                'price' => 75000000,
                'bedrooms' => 5,
                'bathrooms' => 5,
                'area_size' => 4500,
                'garage' => 3,
                'property_type' => 'sale',
                'latitude' => 23.8820,
                'longitude' => 90.3860,
                'image' => 'properties/property10.jpg',
            ],

            // ===== KHULNA (5 properties) =====
            [
                'title' => 'New Apartment in Sonadanga',
                'category' => 'Apartment',
                'description' => 'Brand new 3-bedroom apartment located in the upscale Sonadanga Residential Area of Khulna. This modern unit features a spacious living-dining combo, contemporary kitchen with granite countertops, and three bedrooms with attached bathrooms. The apartment offers beautiful city views from the balcony, tiled flooring throughout, and provision for modern amenities including air conditioning and gas connection. The building has a generator, water reservoir, and security system. Sonadanga is Khulna\'s most sought-after neighborhood with wide roads, parks, and proximity to the city\'s commercial center.',
                'division' => 'Khulna',
                'city' => 'Khulna',
                'location' => 'Sonadanga Residential Area, Khulna 9100',
                'price' => 8500000,
                'bedrooms' => 3,
                'bathrooms' => 3,
                'area_size' => 1400,
                'garage' => 1,
                'property_type' => 'sale',
                'latitude' => 22.8456,
                'longitude' => 89.5403,
                'image' => 'properties/property11.jpg',
            ],
            [
                'title' => 'Independent House in Khalishpur',
                'category' => 'Residential House',
                'description' => 'Well-maintained independent house in the established Khalishpur area of Khulna. This 3-bedroom home offers comfortable family living with a generous living room, separate dining area, and a functional kitchen. The property includes a small courtyard garden perfect for children and outdoor relaxation. Located in a quiet neighborhood with good road access, the house is close to schools, markets, hospitals, and the Khalishpur railway station. The area has seen steady development making it an excellent choice for families seeking affordable housing in Khulna city.',
                'division' => 'Khulna',
                'city' => 'Khulna',
                'location' => 'Khalishpur, Khulna 9000',
                'price' => 6500000,
                'bedrooms' => 3,
                'bathrooms' => 2,
                'area_size' => 1600,
                'garage' => 1,
                'property_type' => 'sale',
                'latitude' => 22.8505,
                'longitude' => 89.5310,
                'image' => 'properties/property12.jpg',
            ],
            [
                'title' => 'Modern Duplex in Daulatpur',
                'category' => 'Duplex',
                'description' => 'Contemporary duplex residence in the developing Daulatpur area of Khulna. This two-story home features an open-plan ground floor with living room, dining area, and modern kitchen. The upper floor houses three bedrooms with attached bathrooms and a small family sitting area. The property boasts modern finishes including vitrified tile flooring, decorative ceiling designs, and aluminum windows. Daulatpur offers a peaceful residential environment with easy access to the city center and is becoming increasingly popular among professionals and business owners.',
                'division' => 'Khulna',
                'city' => 'Khulna',
                'location' => 'Daulatpur, Khulna 9200',
                'price' => 9500000,
                'bedrooms' => 3,
                'bathrooms' => 3,
                'area_size' => 2000,
                'garage' => 1,
                'property_type' => 'sale',
                'latitude' => 22.8555,
                'longitude' => 89.5250,
                'image' => 'properties/property13.jpg',
            ],
            [
                'title' => 'Residential Plot in Gollamari',
                'category' => 'Residential Plot',
                'description' => 'Excellent residential plot located in Gollamari, a fast-growing area of Khulna city. This 3 katha plot is situated on a paved road with electricity, gas, water, and sewer connections readily available. The land is elevated, well-drained, and suitable for immediate construction. Gollamari offers a more affordable alternative to central Khulna while still providing good access to the city\'s amenities, educational institutions, and the Khulna City Bypass. Perfect for building a dream home or as a real estate investment with strong appreciation potential.',
                'division' => 'Khulna',
                'city' => 'Khulna',
                'location' => 'Gollamari, Khulna 9100',
                'price' => 3500000,
                'bedrooms' => 0,
                'bathrooms' => 0,
                'area_size' => 2160,
                'garage' => 0,
                'property_type' => 'sale',
                'latitude' => 22.8400,
                'longitude' => 89.5480,
                'image' => 'properties/property14.jpg',
            ],
            [
                'title' => 'Commercial Office in Boyra',
                'category' => 'Commercial Office',
                'description' => 'Well-located commercial office space in Boyra, one of Khulna\'s emerging business hubs. This ground-floor office features a reception area, two private rooms, an open workspace, and a washroom. The property has large windows providing natural light, good ventilation, and street-facing visibility ideal for retail or service businesses. Boyra enjoys excellent connectivity to all parts of Khulna city and is close to Khulna University and major hospitals. Suitable for clinics, law offices, real estate agencies, or small business operations.',
                'division' => 'Khulna',
                'city' => 'Khulna',
                'location' => 'Boyra Main Road, Khulna 9000',
                'price' => 5500000,
                'bedrooms' => 0,
                'bathrooms' => 1,
                'area_size' => 800,
                'garage' => 0,
                'property_type' => 'sale',
                'latitude' => 22.8600,
                'longitude' => 89.5550,
                'image' => 'properties/property15.jpg',
            ],

            // ===== CHATTOGRAM (5 properties) =====
            [
                'title' => 'Premium Office Space in Agrabad',
                'category' => 'Commercial Office',
                'description' => 'Prime commercial office space in Agrabad Commercial Area, the financial heart of Chattogram. This well-appointed office occupies the 5th floor of a commercial building and offers stunning views of the city and the Bay of Bengal. The space includes a reception lobby, executive cabin, open-plan workstations for 15 people, a conference room, and pantry. The building features modern amenities including high-speed internet connectivity, central air conditioning, multiple elevators, and basement parking. Agrabad is home to major banks, corporate headquarters, and the Chattogram Stock Exchange.',
                'division' => 'Chattogram',
                'city' => 'Chattogram',
                'location' => 'Agrabad Commercial Area, Chattogram 4100',
                'price' => 28000000,
                'bedrooms' => 0,
                'bathrooms' => 2,
                'area_size' => 1600,
                'garage' => 1,
                'property_type' => 'sale',
                'latitude' => 22.3250,
                'longitude' => 91.8110,
                'image' => 'properties/property16.jpg',
            ],
            [
                'title' => 'Luxury Villa in Khulshi',
                'category' => 'Villa',
                'description' => 'Magnificent luxury villa located in the exclusive Khulshi Residential Area of Chattogram. This expansive 5-bedroom residence offers the ultimate in comfortable living with a grand entrance lobby, formal living and dining rooms, family lounge, modern kitchen with breakfast area, and a library. The first floor features a master suite with walk-in closet and spa-like bathroom, plus three additional bedrooms. Outside, the property boasts a manicured garden, swimming pool, outdoor entertainment area, and parking for four vehicles. Khulshi is Chattogram\'s most prestigious address.',
                'division' => 'Chattogram',
                'city' => 'Chattogram',
                'location' => 'Khulshi Residential Area, Chattogram 4200',
                'price' => 65000000,
                'bedrooms' => 5,
                'bathrooms' => 5,
                'area_size' => 5000,
                'garage' => 2,
                'property_type' => 'sale',
                'latitude' => 22.3605,
                'longitude' => 91.8200,
                'image' => 'properties/property17.jpg',
            ],
            [
                'title' => 'Spacious Apartment in Panchlaish',
                'category' => 'Apartment',
                'description' => 'Beautiful 3-bedroom apartment in the serene Panchlaish area of Chattogram. This well-designed unit features a bright and spacious living room, separate dining area, modular kitchen with quartz countertops, and three bedrooms with attached bathrooms. The apartment offers panoramic hill views from its balcony, a rare treat in city living. The building includes elevator access, generator backup, caretaker services, and visitor parking. Panchlaish is known for its peaceful environment, hillside location, and proximity to Chattogram\'s top schools and hospitals.',
                'division' => 'Chattogram',
                'city' => 'Chattogram',
                'location' => 'Panchlaish, Chattogram 4203',
                'price' => 14000000,
                'bedrooms' => 3,
                'bathrooms' => 3,
                'area_size' => 1550,
                'garage' => 1,
                'property_type' => 'sale',
                'latitude' => 22.3525,
                'longitude' => 91.8310,
                'image' => 'properties/property18.jpg',
            ],
            [
                'title' => 'Family House in Halishahar',
                'category' => 'Residential House',
                'description' => 'Comfortable family house located in the sprawling Halishahar residential area of Chattogram. This 4-bedroom home offers generous living spaces with a large living room, separate dining area, modern kitchen, and a rooftop terrace perfect for family gatherings. The property features ceramic tile flooring, aluminum sliding windows, and a small front garden. Halishahar is a well-planned residential area with wide roads, parks, community centers, and easy access to the Chattogram-Cox\'s Bazar highway. Ideal for families seeking a balanced lifestyle in Chattogram.',
                'division' => 'Chattogram',
                'city' => 'Chattogram',
                'location' => 'Halishahar, Chattogram 4100',
                'price' => 16000000,
                'bedrooms' => 4,
                'bathrooms' => 3,
                'area_size' => 2200,
                'garage' => 1,
                'property_type' => 'sale',
                'latitude' => 22.3350,
                'longitude' => 91.7950,
                'image' => 'properties/property19.jpg',
            ],
            [
                'title' => 'Modern Duplex Near GEC Circle',
                'category' => 'Duplex',
                'description' => 'Contemporary duplex apartment near the iconic GEC Circle in Chattogram city center. This stylish two-level home features an open ground floor with modern living and dining areas, a sleek kitchen, and a guest bathroom. The upper level houses three bedrooms including a master suite with dressing area and attached bathroom. Premium finishes include wooden flooring in bedrooms, designer light fixtures, and imported bathroom fittings. Located minutes from GEC Circle, this property offers unparalleled access to Chattogram\'s best shopping, dining, and entertainment options.',
                'division' => 'Chattogram',
                'city' => 'Chattogram',
                'location' => 'GEC Circle, Chattogram 4200',
                'price' => 22000000,
                'bedrooms' => 3,
                'bathrooms' => 3,
                'area_size' => 2100,
                'garage' => 1,
                'property_type' => 'sale',
                'latitude' => 22.3560,
                'longitude' => 91.8260,
                'image' => 'properties/property20.jpg',
            ],
        ];

        $sellerPool = $sellerIds;
        $propertyIds = [];

        foreach ($properties as $prop) {
            $sellerId = $sellerPool[array_rand($sellerPool)];
            $prop['seller_id'] = $sellerId;
            $prop['category_id'] = $catMap[$prop['category']];
            $prop['status'] = 'available';
            $prop['approval_status'] = 'approved';
            unset($prop['category']);

            $property = Property::create($prop);
            $propertyIds[] = $property->id;
        }

        $buyerIds = User::where('role', 'buyer')->pluck('id')->toArray();

        foreach ($buyerIds as $buyerId) {
            $randomProperties = array_rand(array_flip($propertyIds), min(4, count($propertyIds)));
            if (!is_array($randomProperties)) {
                $randomProperties = [$randomProperties];
            }
            foreach ($randomProperties as $propId) {
                Favorite::factory()->create([
                    'buyer_id' => $buyerId,
                    'property_id' => $propId,
                ]);
            }
        }

        $visitProperties = array_slice($propertyIds, 0, min(8, count($propertyIds)));
        foreach ($visitProperties as $propId) {
            if (!empty($buyerIds)) {
                VisitRequest::factory()->create([
                    'property_id' => $propId,
                    'buyer_id' => $buyerIds[array_rand($buyerIds)],
                ]);
            }
        }
    }
}
