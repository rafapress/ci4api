// Token de autenticação para a API
const token = 'd3f81a9e5e4a7c0f3a2d9b7c1c30f8e2';

// URL base da API
const apiUrl = 'http://localhost:8081/api/users';

// Guarda o ID do usuário criado/selecionado
let userId = '';

// Função auxiliar para realizar requisições à API
async function apiRequest(method, url, token = null, body = null) {

  const options = {
    method,
    headers: {
      'Content-Type': 'application/json',
      ...(token && { 'Authorization': `Bearer ${token}` })
    },
    ...(body && { body: JSON.stringify(body) })
  };

  const res = await fetch(url, options);
  const data = await res.json();

  if (!res.ok) {
    const message = data?.messages?.error || data?.error || data?.message || `Erro: ${res.status}`;
    throw new Error(`${res.status} - ${message}`);
  }

  return data;

}

// -----------------------------------------------------------
// CREATE (POST): Cadastrar usuário
// -----------------------------------------------------------
document.getElementById('btnCadastrar').addEventListener('click', async () => {

  const btn = event.target;
  const output = document.getElementById('outputCadastrar');
  btn.disabled = true;
  output.textContent = 'Cadastrando...';

  try {
    // Dados do usuário a ser cadastrado
    const newUser = {
      name: 'Juliano Alves',
      email: 'juliano.alves@email.com',
      phone: '(19) 97888.3499'
    };

    // Envia POST para api/users com os dados no body
    const data = await apiRequest('POST', apiUrl, token, newUser);

    // Guarda o ID retornado para uso futuro
    userId = data.data.id;

    output.textContent = JSON.stringify(data.data, null, 2);
  } catch (err) {
    output.textContent = err.message;
  } finally {
    btn.disabled = false;
  }

});

// -----------------------------------------------------------
// READ (GET): Listar usuários ou usuário específico
// -----------------------------------------------------------
document.getElementById('btnListar').addEventListener('click', async () => {

  const btn = event.target;
  const output = document.getElementById('outputListar');
  btn.disabled = true;
  output.textContent = 'Carregando...';

  try {
    // Se userId existe, busca usuário específico, senão lista todos
    const url = userId ? `${apiUrl}/${userId}` : apiUrl;

    // Envia GET para a URL correta
    const data = await apiRequest('GET', url, token);

    output.textContent = JSON.stringify(data, null, 2);
  } catch (err) {
    output.textContent = err.message;
  } finally {
    btn.disabled = false;
  }

});

// -----------------------------------------------------------
// UPDATE (PUT): Alterar usuário pelo ID
// -----------------------------------------------------------
document.getElementById('btnAlterar').addEventListener('click', async () => {

  const btn = event.target;
  const output = document.getElementById('outputAlterar');
  btn.disabled = true;
  output.textContent = 'Atualizando...';

  if (!userId) {
    output.textContent = 'Usuário ainda não cadastrado.';
    btn.disabled = false;
    return;
  }

  try {
    // Novos dados para atualização
    const updatedData = {
      name: 'Novo Nome',
      email: 'novo@email.com',
      cpf: '999.899.289/11',
      rg: '43.894.799-7',
      phone: '(11) 99876.8932',
      address: 'Rua das Azaléias',
      number: '388',
      district: 'Centro',
      city: 'Vinhedo',
      fu: 'SP'
    };

    // Envia PUT para api/users/{id} com os dados atualizados
    const data = await apiRequest('PUT', `${apiUrl}/${userId}`, token, updatedData);

    output.textContent = data.message;
  } catch (err) {
    output.textContent = err.message;
  } finally {
    btn.disabled = false;
  }

});

// -----------------------------------------------------------
// DELETE (DELETE): Excluir usuário pelo ID
// -----------------------------------------------------------
document.getElementById('btnExcluir').addEventListener('click', async () => {

  const btn = event.target;
  const output = document.getElementById('outputExcluir');
  btn.disabled = true;
  output.textContent = 'Excluindo...';

  if (!userId) {
    output.textContent = 'Usuário não encontrado.';
    btn.disabled = false;
    return;
  }

  try {
    // Envia DELETE para api/users/{id}
    const data = await apiRequest('DELETE', `${apiUrl}/${userId}`, token);

    output.textContent = data.message;

    // Limpa o ID porque usuário foi excluído
    userId = '';
  } catch (err) {
    output.textContent = err.message;
  } finally {
    btn.disabled = false;
  }

});