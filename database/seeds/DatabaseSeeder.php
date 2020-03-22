<?php

use Faker\Factory;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Group Users
        factory(App\Group::class)->create(['name'  => 'ND']);
        factory(App\Group::class)->create(['name'  => 'ARQUITECTO']);
        factory(App\Group::class)->create(['name'  => 'INGENIERO']);
        factory(App\Group::class)->create(['name'  => 'ESPECIALISTA']);
        factory(App\Group::class)->create(['name'  => 'OBRERO']);
        factory(App\Group::class)->create(['name'  => 'PROFESIONAL']);
        factory(App\Group::class)->create(['name'  => 'PROVEEDOR']);

        // Page to visit
//        App\Page::create([
//            'parent_id' => null,
//            'title'     => 'Quines somos',
//            'slug'      => 'quienes-somos',
//            'body'      => 'Contenido de quienes somos'
//        ]);
//
//        App\Page::create([
//            'parent_id' => 1,
//            'title'     => 'Misión',
//            'slug'      => 'mision',
//            'body'      => 'Contenido de mision'
//        ]);
//
//        App\Page::create([
//            'parent_id' => 1,
//            'title'     => 'Visión',
//            'slug'      => 'vision',
//            'body'      => 'Contenido de vision'
//        ]);

        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        Permission::create(['name' => 'Administer roles & permissions']);
        Permission::create(['name' => 'Create Post']);
        Permission::create(['name' => 'Edit Post']);
        Permission::create(['name' => 'Delete Post']);
        Permission::create(['name' => 'Publish Post']);
        Permission::create(['name' => 'Unpublish Post']);
        Permission::create(['name' => 'Comment Post']);

        // create roles and assign existing permissions
        $role = Role::create(['name' => 'admin']);
        $role->givePermissionTo(['Administer roles & permissions', 'Create Post', 'Edit Post', 'Delete Post',  'Publish Post', 'Unpublish Post', 'Comment Post']);

        $role = Role::create(['name' => 'user']);
        $role->givePermissionTo('Comment Post');

        $role = Role::create(['name' => 'writer']);
        $role->givePermissionTo('Create Post');

        $role_user = Role::where('name', 'user')->first();
        $role_admin = Role::where('name', 'admin')->first();

        // Users
        $user = App\User::create([
            'name'       => 'Angel Vanegas',
            'email'      => 'avanepe@hotmail.com',
            'password'   => 'alvape14', // $2y$10$dbymzN9zuLXmIY5f/c5NzuWIHDv//EcVU/AeqaexOHuY6uJeduNx2' //alvape14
            'api_token' => Str::random(60)
        ]);
        $user->roles()->attach($role_admin);
        $profile = $user->profile()->save(factory(App\Profile::class)->make());
        $profile->location()->save(factory(App\Location::class)->make());
        $user->groups()->attach($this->array(rand(1,7)));
        $user->image()->save(factory(App\Image::class)->make([
            'url' => 'persona-00.jpg'
        ]));

        $users = factory(App\User::class,9)->create();
        foreach($users as $user){
            $user->assignRole('user');
            $profile = $user->profile()->save(factory(App\Profile::class)->make());
            $profile->location()->save(factory(App\Location::class)->make());
            $user->groups()->attach($this->array(rand(1,7)));
            $user->image()->save(factory(App\Image::class)->make([
                'url' => 'profile.png'
            ]));
        }
        // Category
        factory(App\Models\Post\Category::class)->create(['name'  => 'Arquitectura', 'slug' => 'arquitectura', 'body' => 'Criterios y fundamentos arquitectónicos. ']);
        factory(App\Models\Post\Category::class)->create(['name'  => 'Ingenieria', 'slug' => 'ingenieria', 'body' => 'Principios y fundamentos de ingeniería.']);
        factory(App\Models\Post\Category::class)->create(['name'  => 'Diseño arquitectónico', 'slug' => 'diseno-arquitectonico', 'body' => 'Diseño arquitectónico.']);
        factory(App\Models\Post\Category::class)->create(['name'  => 'Diseño estructural', 'slug' => 'diseno-estructural', 'body' => 'Diseño estructural.']);
        factory(App\Models\Post\Category::class)->create(['name'  => 'Procesos constructivos', 'slug' => 'procesos-constructivos', 'body' => 'Procesos constructivos.']);
        factory(App\Models\Post\Category::class)->create(['name'  => 'Biblioteca', 'slug' => 'biblioteca', 'body' => 'Artículos del área de la construccion, biblioteca básica.']);
        factory(App\Models\Post\Category::class)->create(['name'  => 'Materiales de construcción', 'slug' => 'materiales-de-construccion', 'body' => 'Materiales para la construcción de obras de ingeniería civil.']);
        factory(App\Models\Post\Category::class)->create(['name'  => 'Diseño eléctrico y electrónico', 'slug' => 'diseño-electrico-y-electronico', 'body' => 'Diseño eléctrico, electrónico, ambiental, redes, y más.']);
        factory(App\Models\Post\Category::class)->create(['name'  => 'Materiales para acabados con Madera, Hierro y aluminio, etc.', 'slug' => 'materiales-para-acabados-de-madera-Hierro-y-aluminio', 'body' => 'Material para acabados de techos, jardines y exteriores.']);
        factory(App\Models\Post\Category::class)->create(['name'  => 'Diseño hidráulico y sanitario', 'slug' => 'diseno-hidraulico-y-sanitario', 'body' => 'Diseño hidráulico y sanitario']);
        factory(App\Models\Post\Category::class)->create(['name'  => 'Material para acabados de pisos y paredes', 'slug' => 'material-para-acabados-de-pisos-y-paredes', 'body' => 'Material para acabados de pisos y paredes']);
        //factory(App\Models\Post\Category::class, 10)->create();

        // Tag
        factory(App\Models\Post\Tag::class)->create(['name'  => 'Arquitectura', 'slug' => 'arquitectura']);
        factory(App\Models\Post\Tag::class)->create(['name'  => 'Ingeniería', 'slug' => 'ingenieria']);
        factory(App\Models\Post\Tag::class)->create(['name'  => 'Costo', 'slug' => 'costo']);
        factory(App\Models\Post\Tag::class)->create(['name'  => 'Valor', 'slug' => 'valor']);
        factory(App\Models\Post\Tag::class)->create(['name'  => 'Diseño', 'slug' => 'diseno']);
        factory(App\Models\Post\Tag::class)->create(['name'  => 'Madera', 'slug' => 'madera']);
        factory(App\Models\Post\Tag::class)->create(['name'  => 'Acero de refuerzo', 'slug' => 'acer-de-refuerzo']);
        factory(App\Models\Post\Tag::class)->create(['name'  => 'Cemento', 'slug' => 'cemento']);
        factory(App\Models\Post\Tag::class)->create(['name'  => 'Hormigón', 'slug' => 'hormigon']);
        factory(App\Models\Post\Tag::class)->create(['name'  => 'Arena', 'slug' => 'arena']);
        factory(App\Models\Post\Tag::class)->create(['name'  => 'Grava', 'slug' => 'grava']);
        factory(App\Models\Post\Tag::class)->create(['name'  => 'Agua', 'slug' => 'agua']);
        factory(App\Models\Post\Tag::class)->create(['name'  => 'Mano de obra', 'slug' => 'mano-de-obra']);
        factory(App\Models\Post\Tag::class)->create(['name'  => 'Reajuste de precios', 'slug' => 'reajuste-de-precios']);
        factory(App\Models\Post\Tag::class)->create(['name'  => 'Hidráulico', 'slug' => 'hidraulico']);
        factory(App\Models\Post\Tag::class)->create(['name'  => 'Sanitario', 'slug' => 'sanitario']);
        factory(App\Models\Post\Tag::class)->create(['name'  => 'Mortero', 'slug' => 'mortero']);
        factory(App\Models\Post\Tag::class)->create(['name'  => 'Hierro', 'slug' => 'hierro']);
        factory(App\Models\Post\Tag::class)->create(['name'  => 'Suelda', 'slug' => 'suelda']);
        factory(App\Models\Post\Tag::class)->create(['name'  => 'Aluminio', 'slug' => 'aluminio']);
        //factory(App\Models\Post\Tag::class, 20)->create();

        // Ofertas
        factory(App\Models\Oferta\Oferta::class)->create([
            'user_id'   => 1,
            'name'      => 'Motor de impresora',
            'unidad'    => 'u',
            'descripcion' => 'Lo mejor de lo mejor',
            'stock'     => '4',
            'precio'    => '150.60',
            'file'      => 'caracteristicas.txt',
            'status'    => TRUE,
            ])->each(function($oferta){
                $oferta->image()->save(factory(App\Image::class)->make(['url' => 'oferta1.jpg']));
            });

        factory(App\Models\Post\Post::class, 40)->create()->each(function ($post) {

            $post->image()->save(factory(App\Image::class)->make());
            $post->tags()->attach($this->array(rand(1,20)));

            $number_comments = rand(1, 6);

            for ($i = 0; $i < $number_comments; $i++) {
                $post->comments()->save(factory(App\Models\Post\Comment::class)->make());
            }

        });

        factory(App\Zona::class, 10)->create();
        factory(App\Models\Data\GrupoEquipo::class,10)->create();
        factory(App\Models\Data\GrupoMaterial::class,10)->create();
        factory(App\Models\Data\GrupoObrero::class,10)->create();
        factory(App\Models\Precio\GrupoPrecio::class,10)->create();

        factory(App\Models\Data\Equipo::class, 10)->create();
        factory(App\Models\Data\Material::class,10)->create();
        factory(App\Models\Data\Obrero::class,10)->create();
        factory(App\Models\Data\Transporte::class,10)->create();

        //precios
        $faker = Factory::create();
        //Precio::truncate();
        //PrecioEquipo::truncate();
        //PrecioMaterial::truncate();
        //PrecioObrero::truncate();
        //PrecioTransporte::truncate();

        foreach(range(1, 10) as $i) {
            App\Models\Precio\Precio::create([
                'user_id'         => $i,
                'grupo_precio_id' => $i,
                'name'            => $faker->sentence,
                'unidad'          => $faker->word,
                'detalle'         => $faker->paragraph(mt_rand(1, 2)),
                'directo'         => $faker->randomFloat(5, 1.20, 120),
                'indirecto'       => 18,
            ]);
            foreach(range(1, mt_rand(3, 5)) as $j) {
                App\Models\Precio\PrecioEquipo::create([
                    'precio_id'  => $i,
                    'equipo_id'  => mt_rand(1, 10),
                    'name'       => $faker->sentence,
                    'tarifa'     => 1.20,
                    'cantidad'   => 2.42,
                    'rendimiento'=> 1.28,
                    'total'      => 6.42
                ]);
            }
            foreach(range(1, mt_rand(3, 7)) as $k) {
                App\Models\Precio\PrecioMaterial::create([
                    'precio_id'  => $i,
                    'material_id'=> mt_rand(1, 10),
                    'name'       => $faker->sentence,
                    'unidad'     => $faker->word,
                    'precio'     => 2.1,
                    'cantidad'   => 2.5,
                    'total'      => 5.24
                ]);
            }
            foreach(range(1, mt_rand(3, 7)) as $l) {
                App\Models\Precio\PrecioObrero::create([
                    'precio_id'  => $i,
                    'obrero_id'  => mt_rand(1, 10),
                    'name'       => $faker->sentence,
                    'jornalhora' => 2.15,
                    'cantidad'   => 1.20,
                    'rendimiento'=> 2.05,
                    'total'      => 6.42
                ]);
            }
            foreach(range(1, mt_rand(1, 4)) as $m) {
                App\Models\Precio\PrecioTransporte::create([
                    'precio_id'     => $i,
                    'transporte_id' =>mt_rand(1, 10),
                    'name'          => $faker->sentence,
                    'unidad'        => $faker->word,
                    'tarifa'        => 2.64,
                    'cantidad'      => 2.4,
                    'distancia'     => 2.20,
                    'total'         => 6.42,
                ]);
            }
        }

        //proyectos
        $faker = Factory::create();
        //Proyecto::truncate();
        //ProyectoRubro::truncate();

        foreach(range(1, 20) as $i) {
            $rubros = collect();
            foreach(range(1, mt_rand(3, 10)) as $j) {
                $cantidad = $faker->numberBetween(1, 100);
                $precio   = $faker->numberBetween(1, 999);
                $rubros->push(new App\Models\Proyecto\ProyectoRubro([
                    'proyecto_id' => $i,
                    'precio_id'   => mt_rand(100, 999),
                    'orden'       => $j,
                    'rubro'       => $faker-> sentence($nbWords = 2, $variableNbWords = true),
                    'unidad'      => $faker-> word(),
                    'cantidad'    => $cantidad,
                    'precio'      =>  $precio,
                    'total'       => ($cantidad*$precio)
                ]));
            }

            $subTotal  = $rubros->sum('total');
            $descuento = $subTotal*0.12;
            $total     = $subTotal + $descuento;

            $proyecto  = App\Models\Proyecto\Proyecto::create([
                'user_id'       => mt_rand(1, 10),
                'name'          => $faker->sentence($nbWords = 2, $variableNbWords = true),
                'contratante'   => $faker->catchPhrase,
                'ubicacion'     => $faker->sentence($nbWords = 2, $variableNbWords = true),
                'oferente'      => $faker->name(),
                'entrega'       => $faker->date(),
                'referencial'   => $faker->numberBetween(1000, 200000),
                'indirecto'     => $faker->numberBetween(10, 20),
                'descuento'     => $descuento,
                'distancia'     => $faker->numberBetween(1, 100),
                'sub_total'     => $subTotal,
                'gran_total'    => $total,
                'formato'       => 5,
                'precision'     => $faker->numberBetween(2, 4),
                'representante' => $faker->name()
            ]);

            $proyecto->rubros()->saveMany($rubros);
        }
    }

    public function array($max)
    {
        $values = [];
        for ($i=1; $i < $max; $i++) {
            $values[] = $i;
        }
        return $values;
    }
}
