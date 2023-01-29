// Nombre del alumno Alberto Pascual y Andres Romero
// Usuario del Juez PC07


#include <iostream>
#include <iomanip>
#include <fstream>
#include<vector>
#include<unordered_set>
using namespace std;



struct UFDS {
    vector<int> p;
    int numSets;
    UFDS(int n) : p(n, 0), numSets(n) {
        for (int i = 0; i < n; ++i) p[i] = i;
    }
    int find(int x) {
        return (p[x] == x) ? x : p[x] = find(p[x]);
    }
    void merge(int x, int y) {
        int i = find(x), j = find(y);
        if (i == j) return;
        p[i] = j;
        --numSets;
    }
};

// Resuelve un caso de prueba, leyendo de la entrada la
// configuracioon, y escribiendo la respuesta
bool resuelveCaso() {
    // leer los datos de la entrada
    int n1, n2;
    cin >> n1;

    if (!std::cin)
        return false;


    using arista = pair<int, pair <int, int>>; // < coste, extremos >
    vector<arista > aristas;

    cin >> n2;
 //   unordered_set<int> nodos;

    arista a;
    a.first = 0;
    a.second.first = n1;
    a.second.second = n2;
    aristas.push_back(a);
  //  nodos.insert(n1);
  //  nodos.insert(n2);

    cin >> n1;
    while (n1 != -1)
    {
        cin >> n2;
        a.first = 0;
        a.second.first = n1;
        a.second.second = n2;
        aristas.push_back(a);
  //      nodos.insert(n1);
  //      nodos.insert(n2);

        cin >> n1;
    }

 //   int nNodos = nodos.size();
    UFDS uf(100001);
    int coste = 0;
    int count = 0;
   // double costeDelUltimo = 0;
    for (auto ar : aristas)
    {
        if (uf.find(ar.second.first) != uf.find(ar.second.second))//comprueba que no se cree ciclo
        {
            uf.merge(ar.second.first, ar.second.second);
            coste += ar.first;
     /*       if (uf.numSets == 1) {//tenemos nSatelites conexiones "gratis", no hace falta calcular su coste
                //�por que no es 1+ nStaelites?
              //  costeDelUltimo = sqrt(ar.first);
                cout << std::fixed;
                cout << std::setprecision(2);
                cout << costeDelUltimo << endl;
                break;

            }*/
        }
        else//si habia ciclo, arista eleiminada. Aumentamos ocntador
        {
            count++;
        }
    }
    // escribir sol
    cout << count << endl;

    return true;

}

int main() {
    // Para la entrada por fichero.
    // Comentar para acepta el reto
#ifndef DOMJUDGE
    std::ifstream in("sample-L23.1.in");
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