INSERT INTO
    `teacher`(`name`, `last_name`)
VALUES
    ('Ramon', 'Arreola'), -- #1
    ('Juan Manuel', 'Trejo'), -- #2
    ('Martin', 'Tinajero'), -- #3
    ('Pendiente', ''), -- #4
    ('Mariana', 'Caballero'), -- #5
    ('Karina', 'Beltran'), -- #6
    ('Norma', 'y Betty'), -- #7
    ('Andres', 'Diego'), -- #8
    ('Ignacio', 'Tinajero'), -- #9
    ('Ramiro', 'Valdez'), -- #10
    ('Ceci', 'Ruiz'), -- #11
    ('Erick', 'Perez'), -- #12
    ('Maricela', 'Caballero'), -- #13
    ('Eli', 'Hernandez'), -- #14
    ('Maribel', 'Caballero'), -- #15
    ('Rafa Jimenez', 'y Flor'), -- #16
    ('Isabel', 'Zepeda'); -- #17


INSERT INTO
    `workshop`(
        `name`,
        `image_url`,
        `max_capacity`,
        `teacher_id`
    )
VALUES
    (
        'Futbol Femenil',
        'https://raw.githubusercontent.com/MXJosueDev/workshops-statics/main/images/futbol_femenil.webp',
        '25',
        '1'
    ),
    (
        'Futbol Varonil',
        'https://raw.githubusercontent.com/MXJosueDev/workshops-statics/main/images/futbol_varonil.webp',
        '20',
        '2'
    ),
    (
        'Basquetbol Mixto',
        'https://raw.githubusercontent.com/MXJosueDev/workshops-statics/main/images/basquetbol_mixto.webp',
        '20',
        '3'
    ),
    (
        'Voleibol',
        'https://raw.githubusercontent.com/MXJosueDev/workshops-statics/main/images/voleibol.webp',
        '24',
        '4'
    ),
    (
        'Cardio-Hit',
        'https://raw.githubusercontent.com/MXJosueDev/workshops-statics/main/images/cardio-hit.webp',
        '25',
        '5'
    ),
    (
        'Bastoneras',
        'https://raw.githubusercontent.com/MXJosueDev/workshops-statics/main/images/bastoneras.webp',
        '40',
        '6'
    ),
    (
        'Porristas',
        'https://raw.githubusercontent.com/MXJosueDev/workshops-statics/main/images/porristas.webp',
        '60',
        '7'
    ),
    (
        'Ajedrez',
        'https://raw.githubusercontent.com/MXJosueDev/workshops-statics/main/images/ajedrez.webp',
        '25',
        '8'
    ),
    (
        'Robotica',
        'https://raw.githubusercontent.com/MXJosueDev/workshops-statics/main/images/robotica.webp',
        '20',
        '9'
    ),
    (
        'Banda de Guerra',
        'https://raw.githubusercontent.com/MXJosueDev/workshops-statics/main/images/banda_guerra.webp',
        '24',
        '10'
    ),
    (
        'Danza',
        'https://raw.githubusercontent.com/MXJosueDev/workshops-statics/main/images/danza.webp',
        '17',
        '11'
    ),
    (
        'Animadores',
        'https://raw.githubusercontent.com/MXJosueDev/workshops-statics/main/images/animadores.webp',
        '30',
        '12'
    ),
    (
        'Canto y Guitarra',
        'https://raw.githubusercontent.com/MXJosueDev/workshops-statics/main/images/canto_y_guitarra.webp',
        '20',
        '13'
    ),
    (
        'Teatro',
        'https://raw.githubusercontent.com/MXJosueDev/workshops-statics/main/images/teatro.webp',
        '24',
        '14'
    ),
    (
        'Creaciones Literarias',
        'https://raw.githubusercontent.com/MXJosueDev/workshops-statics/main/images/creaciones_literarias.webp',
        '12',
        '15'
    ),
    (
        'Huerto Escolar',
        'https://raw.githubusercontent.com/MXJosueDev/workshops-statics/main/images/huerto_escolar.webp',
        '30',
        '16'
    ),
    (
        'Tejido y Reposteria basica',
        'https://raw.githubusercontent.com/MXJosueDev/workshops-statics/main/images/tejido_reposteria.webp',
        '12',
        '17'
    );
