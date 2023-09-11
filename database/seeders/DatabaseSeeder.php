<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        //Tipos de usuarios
        \App\Models\Rol::create([
            'nombre' => "Usuario",
        ]);
        \App\Models\Rol::create([
            'nombre' => "Adolescente",
        ]);
        \App\Models\Rol::create([
            'nombre' => "Administrador",
        ]);
        \App\Models\Rol::create([
            'nombre' => "Administrativo Empresa",
        ]);

        //Tipos de ingresos

        \App\Models\Tipos_ingreso::create([
            'nombre' => 'Sueldo líquido',
        ]);

        \App\Models\Tipos_ingreso::create([
            'nombre' => 'Boletas de honorarios',
        ]);

        \App\Models\Tipos_ingreso::create([
            'nombre' => 'Arriendos',
        ]);

        \App\Models\Tipos_ingreso::create([
            'nombre' => 'Declaración de Renta (anual)',
        ]);

        \App\Models\Tipos_ingreso::create([
            'nombre' => 'Pensión de alimentos recibida',
        ]);

        \App\Models\Tipos_ingreso::create([
            'nombre' => 'Reembolsos o ayudas recibidas',
        ]);

        \App\Models\Tipos_ingreso::create([
            'nombre' => 'Otros ingresos formales o informales'
        ]);

        \App\Models\Tipos_gasto::create([
            'nombre' => 'Hogar'
        ]);
        \App\Models\Tipos_gasto::create([
            'nombre' => 'Servicios básicos'
        ]);
        \App\Models\Tipos_gasto::create([
            'nombre' => 'Alimentos y comida'
        ]);
        \App\Models\Tipos_gasto::create([
            'nombre' => 'Entretenimiento'
        ]);
        \App\Models\Tipos_gasto::create([
            'nombre' => 'Salud y Belleza'
        ]);
        \App\Models\Tipos_gasto::create([
            'nombre' => 'Auto y Transporte'
        ]);
        \App\Models\Tipos_gasto::create([
            'nombre' => 'Educación y trabajo'
        ]);
        \App\Models\Tipos_gasto::create([
            'nombre' => 'Educación y trabajo'
        ]);
        \App\Models\Tipos_gasto::create([
            'nombre' => 'Viajes'
        ]);
        \App\Models\Tipos_gasto::create([
            'nombre' => 'Créditos'
        ]);
        \App\Models\Tipos_gasto::create([
            'nombre' => 'Ropa y Calzado'
        ]);
        \App\Models\Tipos_gasto::create([
            'nombre' => 'Personal'
        ]);
        \App\Models\Tipos_gasto::create([
            'nombre' => 'Compras Online'
        ]);
        \App\Models\Tipos_gasto::create([
            'nombre' => 'Ahorro e Inversiones'
        ]);

        \App\Models\Subtipos_gasto::create([
            'nombre' => 'Artículos para el hogar',
            'id' => 11
        ]);
        \App\Models\Subtipos_gasto::create([
            'nombre' => 'Mascotas',
            'id' => 12
        ]);
        \App\Models\Subtipos_gasto::create([
            'nombre' => 'Limpieza y mantenimiento',
            'id' => 13
        ]);
        \App\Models\Subtipos_gasto::create([
            'nombre' => 'Gasto Común',
            'id' => 14
        ]);
        \App\Models\Subtipos_gasto::create([
            'nombre' => 'Arriendo o dividendo',
            'id' => 15
        ]);
        \App\Models\Subtipos_gasto::create([
            'nombre' => 'Asesora del hogar/niñera/cuidadora',
            'id' => 16
        ]);
        \App\Models\Subtipos_gasto::create([
            'nombre' => 'Seguro al hogar',
            'id' => 17
        ]);
        \App\Models\Subtipos_gasto::create([
            'nombre' => 'Otros hogar',
            'id' => 18
        ]);

        \App\Models\Subtipos_gasto::create([
            'nombre' => 'Agua',
            'id' => 21
        ]);
        \App\Models\Subtipos_gasto::create([
            'nombre' => 'Luz',
            'id' => 22
        ]);
        \App\Models\Subtipos_gasto::create([
            'nombre' => 'Gas',
            'id' => 23
        ]);
        \App\Models\Subtipos_gasto::create([
            'nombre' => 'Cable/Internet',
            'id' => 24
        ]);
        \App\Models\Subtipos_gasto::create([
            'nombre' => 'Alarma',
            'id' => 25
        ]);
        \App\Models\Subtipos_gasto::create([
            'nombre' => 'Telefonía',
            'id' => 26
        ]);


        \App\Models\Subtipos_gasto::create([
            'nombre' => 'Supermercado',
            'id' => 31
        ]);
        \App\Models\Subtipos_gasto::create([
            'nombre' => 'Feria',
            'id' => 32
        ]);
        \App\Models\Subtipos_gasto::create([
            'nombre' => 'Agua en botellón',
            'id' => 33
        ]);
        \App\Models\Subtipos_gasto::create([
            'nombre' => 'Antojos (bebidas, agua, café, snacks)',
            'id' => 34
        ]);
        \App\Models\Subtipos_gasto::create([
            'nombre' => 'Comida rápida',
            'id' => 35
        ]);
        \App\Models\Subtipos_gasto::create([
            'nombre' => 'Gastos en delivery y propinas',
            'id' => 36
        ]);
        \App\Models\Subtipos_gasto::create([
            'nombre' => 'Otros alimentos',
            'id' => 37
        ]);


        \App\Models\Subtipos_gasto::create([
            'nombre' => 'Juguetes y videojuegos',
            'id' => 41
        ]);
        \App\Models\Subtipos_gasto::create([
            'nombre' => 'Suscripciones y apps',
            'id' => 42
        ]);
        \App\Models\Subtipos_gasto::create([
            'nombre' => 'Bares, pubs, restaurantes',
            'id' => 43
        ]);
        \App\Models\Subtipos_gasto::create([
            'nombre' => 'Espectáculos y eventos',
            'id' => 44
        ]);
        \App\Models\Subtipos_gasto::create([
            'nombre' => 'Otros entretenimientos',
            'id' => 45
        ]);


        \App\Models\Subtipos_gasto::create([
            'nombre' => 'Perfumes y cosméticos',
            'id' => 51
        ]);
        \App\Models\Subtipos_gasto::create([
            'nombre' => 'Salón de belleza/Barbería',
            'id' => 52
        ]);
        \App\Models\Subtipos_gasto::create([
            'nombre' => 'Médico/Dentista',
            'id' => 53
        ]);
        \App\Models\Subtipos_gasto::create([
            'nombre' => 'Gimnasio (mensual)',
            'id' => 54
        ]);
        \App\Models\Subtipos_gasto::create([
            'nombre' => 'Arriendo canchas (deporte)',
            'id' => 55
        ]);
        \App\Models\Subtipos_gasto::create([
            'nombre' => 'Farmacia',
            'id' => 56
        ]);
        \App\Models\Subtipos_gasto::create([
            'nombre' => 'Cuidado personal/Terapias',
            'id' => 57
        ]);
        \App\Models\Subtipos_gasto::create([
            'nombre' => 'Otros salud y belleza',
            'id' => 58
        ]);


        \App\Models\Subtipos_gasto::create([
            'nombre' => 'Mantenimiento y reparaciones',
            'id' => 61
        ]);
        \App\Models\Subtipos_gasto::create([
            'nombre' => 'Autolavado',
            'id' => 62
        ]);
        \App\Models\Subtipos_gasto::create([
            'nombre' => 'Transporte público',
            'id' => 63
        ]);
        \App\Models\Subtipos_gasto::create([
            'nombre' => 'Gasolina',
            'id' => 64
        ]);
        \App\Models\Subtipos_gasto::create([
            'nombre' => 'Taxi-Uber-Didi',
            'id' => 65
        ]);
        \App\Models\Subtipos_gasto::create([
            'nombre' => 'Peajes/Autopistas',
            'id' => 66
        ]);
        \App\Models\Subtipos_gasto::create([
            'nombre' => 'Estacionamiento diario',
            'id' => 67
        ]);
        \App\Models\Subtipos_gasto::create([
            'nombre' => 'Estacionamiento mensual',
            'id' => 68
        ]);
        \App\Models\Subtipos_gasto::create([
            'nombre' => 'Seguro',
            'id' => 69
        ]);
        \App\Models\Subtipos_gasto::create([
            'nombre' => 'Otros auto y transporte',
            'id' => 610
        ]);



        \App\Models\Subtipos_gasto::create([
            'nombre' => 'Servicios legales/contables',
            'id' => 71
        ]);
        \App\Models\Subtipos_gasto::create([
            'nombre' => 'Otros educación y trabajo',
            'id' => 72
        ]);
        \App\Models\Subtipos_gasto::create([
            'nombre' => 'Colegiatura',
            'id' => 73
        ]);
        \App\Models\Subtipos_gasto::create([
            'nombre' => 'Academias/Cuotas de curso',
            'id' => 74
        ]);
        \App\Models\Subtipos_gasto::create([
            'nombre' => 'Artículos librería/escritorio',
            'id' => 75
        ]);
        \App\Models\Subtipos_gasto::create([
            'nombre' => 'Transporte Escolar',
            'id' => 76
        ]);
        \App\Models\Subtipos_gasto::create([
            'nombre' => 'Otros educación y trabajo',
            'id' => 77
        ]);


        \App\Models\Subtipos_gasto::create([
            'nombre' => 'Donaciones',
            'id' => 81
        ]);
        \App\Models\Subtipos_gasto::create([
            'nombre' => 'Apoyo a familiares y amigos',
            'id' => 82
        ]);
        \App\Models\Subtipos_gasto::create([
            'nombre' => 'Regalos',
            'id' => 83
        ]);
        \App\Models\Subtipos_gasto::create([
            'nombre' => 'Otros regalos y ayuda',
            'id' => 84
        ]);


        \App\Models\Subtipos_gasto::create([
            'nombre' => 'Hospedaje',
            'id' => 91
        ]);
        \App\Models\Subtipos_gasto::create([
            'nombre' => 'Vuelos',
            'id' => 92
        ]);
        \App\Models\Subtipos_gasto::create([
            'nombre' => 'Otros gastos de viajes',
            'id' => 93
        ]);


        // \App\Models\Subtipos_gasto::create([
        //     'nombre' => 'Casas comerciales',
        //     'id' => 101
        // ]);
        // \App\Models\Subtipos_gasto::create([
        //     'nombre' => 'Créditos de consumo',
        //     'id' => 102
        // ]);
        // \App\Models\Subtipos_gasto::create([
        //     'nombre' => 'Crédito automotriz',
        //     'id' => 103
        // ]);
        // \App\Models\Subtipos_gasto::create([
        //     'nombre' => 'Tarjeta de crédito',
        //     'id' => 104
        // ]);
        // \App\Models\Subtipos_gasto::create([
        //     'nombre' => 'Línea de crédito',
        //     'id' => 105
        // ]);
        // \App\Models\Subtipos_gasto::create([
        //     'nombre' => 'Otros pagos de créditos',
        //     'id' => 106
        // ]);


        SubtiposGasto::create([
            'id' => 101,
            'nombre' => 'Créditos de consumo',
            'created_at' => '2023-08-21 20:44:58',
            'updated_at' => '2023-08-21 20:44:58',
        ]);
        
        SubtiposGasto::create([
            'id' => 102,
            'nombre' => 'Crédito hipotecario',
            'created_at' => '2023-08-21 20:44:58',
            'updated_at' => '2023-08-21 20:44:58',
        ]);
        
        SubtiposGasto::create([
            'id' => 103,
            'nombre' => 'Casas comerciales',
            'created_at' => '2023-08-21 20:44:58',
            'updated_at' => '2023-08-21 20:44:58',
        ]);
        
        SubtiposGasto::create([
            'id' => 104,
            'nombre' => 'Crédito automotriz',
            'created_at' => '2023-08-21 20:44:58',
            'updated_at' => '2023-08-21 20:44:58',
        ]);
        
        SubtiposGasto::create([
            'id' => 105,
            'nombre' => 'Tarjeta de crédito',
            'created_at' => '2023-08-21 20:44:58',
            'updated_at' => '2023-08-21 20:44:58',
        ]);
        
        SubtiposGasto::create([
            'id' => 106,
            'nombre' => 'Línea de crédito',
            'created_at' => '2023-08-21 20:44:58',
            'updated_at' => '2023-08-21 20:44:58',
        ]);
        
        SubtiposGasto::create([
            'id' => 107,
            'nombre' => 'Otros pagos de créditos',
            'created_at' => '2023-08-21 20:44:58',
            'updated_at' => '2023-08-21 20:44:58',
        ]);


        \App\Models\Subtipos_gasto::create([
            'nombre' => 'Calzado',
            'id' => 111
        ]);
        \App\Models\Subtipos_gasto::create([
            'nombre' => 'Accesorios',
            'id' => 112
        ]);
        \App\Models\Subtipos_gasto::create([
            'nombre' => 'Lavandería y tintorería',
            'id' => 113
        ]);
        \App\Models\Subtipos_gasto::create([
            'nombre' => ' Ropa',
            'id' => 114
        ]);
        \App\Models\Subtipos_gasto::create([
            'nombre' => 'Otros Ropa y Cazado',
            'id' => 115
        ]);


        \App\Models\Subtipos_gasto::create([
            'nombre' => 'Impuestos',
            'id' => 121
        ]);
        \App\Models\Subtipos_gasto::create([
            'nombre' => 'Pago pensión de alimentos',
            'id' => 122
        ]);
        \App\Models\Subtipos_gasto::create([
            'nombre' => 'Seguros de vida',
            'id' => 123
        ]);
        \App\Models\Subtipos_gasto::create([
            'nombre' => ' Alcohol',
            'id' => 124
        ]);
        \App\Models\Subtipos_gasto::create([
            'nombre' => 'Tabaco',
            'id' => 125
        ]);
        \App\Models\Subtipos_gasto::create([
            'nombre' => 'Juegos de azar/Apuestas online',
            'id' => 126
        ]);



        \App\Models\Subtipos_gasto::create([
            'nombre' => 'Ali express/Shein',
            'id' => 131
        ]);
        \App\Models\Subtipos_gasto::create([
            'nombre' => 'Grandes tiendas/Mercado libre',
            'id' => 132
        ]);
        \App\Models\Subtipos_gasto::create([
            'nombre' => 'Otras compras online',
            'id' => 133
        ]);



        \App\Models\Subtipos_gasto::create([
            'nombre' => 'Ahorro celebraciones',
            'id' => 141
        ]);
        \App\Models\Subtipos_gasto::create([
            'nombre' => 'Ahorro cumpleaños',
            'id' => 142
        ]);
        \App\Models\Subtipos_gasto::create([
            'nombre' => 'Ahorro Educación',
            'id' => 143
        ]);
        \App\Models\Subtipos_gasto::create([
            'nombre' => 'horro fiestas patrias',
            'id' => 144
        ]);
        \App\Models\Subtipos_gasto::create([
            'nombre' => 'Ahorro fin de semana largo',
            'id' => 145
        ]);
        \App\Models\Subtipos_gasto::create([
            'nombre' => 'Ahorro navidad/año nuevo',
            'id' => 146
        ]);
        \App\Models\Subtipos_gasto::create([
            'nombre' => 'Ahorro viajes/vacaciones',
            'id' => 147
        ]);
        \App\Models\Subtipos_gasto::create([
            'nombre' => 'Fondo de emergencia',
            'id' => 148
        ]);
        \App\Models\Subtipos_gasto::create([
            'nombre' => 'Ahorro general (varios)',
            'id' => 149
        ]);
        \App\Models\Subtipos_gasto::create([
            'nombre' => 'Inversiones y Acciones',
            'id' => 1410
        ]);

        \App\Models\Tipos_deuda::create([
            'nombre' => 'Crédito de consumo',
        ]);
        \App\Models\Tipos_deuda::create([
            'nombre' => 'Crédito hipotecario',
        ]);
        \App\Models\Tipos_deuda::create([
            'nombre' => 'Crédito automotriz',
        ]);
        \App\Models\Tipos_deuda::create([
            'nombre' => 'Compras a crédito',
        ]);

        \App\Models\Banco::create([
            'nombre' => 'Banco BBVA',
        ]);
        \App\Models\Banco::create([
            'nombre' => 'Banco Consorcio',
        ]);
        \App\Models\Banco::create([
            'nombre' => 'Banco de Chile',
        ]);
        \App\Models\Banco::create([
            'nombre' => 'Banco Estado',
        ]);
        \App\Models\Banco::create([
            'nombre' => 'Banco Falabella',
        ]);
        \App\Models\Banco::create([
            'nombre' => 'Banco Internacional',
        ]);
        \App\Models\Banco::create([
            'nombre' => 'Banco Itau',
        ]);
        \App\Models\Banco::create([
            'nombre' => 'Banco Ripley',
        ]);
        \App\Models\Banco::create([
            'nombre' => 'Banco Santander',
        ]);
        \App\Models\Banco::create([
            'nombre' => 'Banco Scotiabank',
        ]);
        \App\Models\Banco::create([
            'nombre' => 'Banco Security',
        ]);
        \App\Models\Banco::create([
            'nombre' => 'Banco BICE',
        ]);
        \App\Models\Banco::create([
            'nombre' => 'Copeuch',
        ]);
        \App\Models\Banco::create([
            'nombre' => 'Corpbanca',
        ]);
        \App\Models\Banco::create([
            'nombre' => 'Banco HSBC Chile',
        ]);
        \App\Models\Banco::create([
            'nombre' => 'Mercado Pago',
        ]);
        \App\Models\Banco::create([
            'nombre' => 'MUFG Bank LTD',
        ]);
        \App\Models\Banco::create([
            'nombre' => 'Otros Bancos',
        ]);
        \App\Models\Banco::create([
            'nombre' => 'Prepago Los Heroes',
        ]);
        \App\Models\Banco::create([
            'nombre' => 'Prepago Tempo',
        ]);
        \App\Models\Banco::create([
            'nombre' => 'TAPP Caja los Andes',
        ]);


        $user = \App\Models\User::create([
            'nombres' => "Mauricio",
            'apellidos' => "nn",
            'rut' => '11111-1',
            'email' => "mauricio@te-apoyo.cl",
            'password' => bcrypt("Mtoatr15"),
            'estado' => 1,
            'intentos' => 3,
            'primera_guia' => 1,
        ]);
        $user->roles()->attach(1);

        $user2 = \App\Models\User::create([
            'nombres' => "Karina",
            'apellidos' => "nn",
            'rut' => '11111-2',
            'email' => "karina@te-apoyo.cl",
            'password' => bcrypt("TeApoyo66"),
            'estado' => 1,
            'intentos' => 3,
            'primera_guia' => 1,
        ]);
        $user2->roles()->attach(1);

        $user3 = \App\Models\User::create([
            'nombres' => "Rodrigo",
            'apellidos' => "nn",
            'rut' => '11111-3',
            'email' => "rodrigo@te-apoyo.cl",
            'password' => bcrypt("Teapoyo66"),
            'estado' => 1,
            'intentos' => 3,
            'primera_guia' => 1,
        ]);
        $user3->roles()->attach(3);
    }
}
