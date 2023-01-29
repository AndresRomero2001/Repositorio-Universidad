// Nombre del alumno .....
// Usuario del Juez ......


#include <iostream>
#include <iomanip>
#include <fstream>
using namespace std;


// función que resuelve el problema

// Resuelve un caso de prueba, leyendo de la entrada la
// configuración, y escribiendo la respuesta
bool resuelveCaso() {
    // leer los datos de la entrada
    int n;
    cin >> n;
    if (! std::cin)
        return false;
    
    int suma = 1; // siempre empieza en 1
    int nDigs = 1;

    //nos vamos quedando con el resto y añadimos un 1 a la derecha y volvemos a sacar el resto hasta 
    // q sea 0 y entonces ya es el multiplo. El num de veces q se hace es el num d digitos
    while (suma % n != 0) {
        suma = (suma * 10 + 1)%n;
        nDigs++;
    }
    
    // escribir sol
    cout << nDigs << endl;
    
    return true;
    
}

int main() {
    // Para la entrada por fichero.
    // Comentar para acepta el reto
    #ifndef DOMJUDGE
     std::ifstream in("sample-39.1.in");
     auto cinbuf = std::cin.rdbuf(in.rdbuf()); //save old buf and redirect std::cin to casos.txt
     #endif 
    
    
    while (resuelveCaso())
        ;

    
    // Para restablecer entrada. Comentar para acepta el reto
     #ifndef DOMJUDGE // para dejar todo como estaba al principio
     std::cin.rdbuf(cinbuf);
     system("PAUSE");
     #endif
    
    return 0;
}