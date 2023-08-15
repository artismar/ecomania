Ecomania - Tienda de productos sustentables.

// Cuentas precargadas para el login
    -- Roles: Administrador, deposito y cliente --
        Cuenta: admin@ecomania.com
        Password: admin123



// Informacion del proyecto
    [No modificar]
    Nombre raiz: ecomania
    Nombre de la base de datos: bdcarritocompras
    Lenguajes utilizados: HTML, CSS, JavaScript y PHP.
    Utilizamos Modelo MVC para la estructura.
    Base de datos: MySQL
    

// Informacion del sitio
    Tienda online dinamica con base de datos que gestiona los productos y los usuarios de la misma.

    Nombre de la marca: Ecomania.
    Rubro: Venta de productos sustentables.


// Informacion de los roles.
    Cada rol tiene sus propios permisos para poder gestionar sus acciones dentro del sitio.
        Si un usuario tiene mas de un rol, debe cambiar entre ellos para realizar sus acciones.
        Si tiene un rol puesto no puede realizar las acciones de otro rol.
            Por ejemplo: Si tiene puesto el rol 'Deposito', no podra comprar ya que esa accion pertenece al rol 'cliente'.

    Por el momento hay estos roles disponibles:

        [Administrador] Encargado de:
            - Gestionar el menu del sitio. Agregando, modificando y eliminando items y cambiar su ruta.
            - Gestionar los pedidos de clientes. Aceptando/enviando/cancelando los pedidos.
            - Gestionar los usuarios. Agregando, modificando y eliminando sus roles y deshabilitar su cuenta. [PROX]

        [Deposito] Encargado de:
            - Gestionar productos. Agrega, modifica (nombre, stock, precio, etc.) y elimina los productos de la tienda.

        [Cliente]
            - Realizar pedidos/compras en la tienda.
            - Gestionar sus pedidos. Poder ver sus pedidos y cancelar los que esten inicializados.
